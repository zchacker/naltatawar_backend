<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Auth\UsersModel;
use App\Models\Payments\CardsTokensModel;
use App\Models\Payments\PaymentsModel;
use App\Models\Subscription\PlansModel;
use App\Models\Subscription\SubscriptionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\isEmpty;

class PaymentController extends Controller
{

    public function pay(Request $request)
    {
        $query = PlansModel::orderByDesc('created_at')->where('id', $request->plan)->first();
        $price = 0;
        $name  = 0;

        if ($query) {
            $name  = $query->name;
            $price = $query->price * 100;// convert to hallah
        }

        Session::put('plan_id', $request->plan); // Save the plan ID in session

        return view('payments.pay', compact('price', 'name'));
    }

    public function callback(Request $request)
    {
        //dd($_GET['id']);

        // 1 - check the payment from backend
        // 2 - save it on database
        // 3 - update user subscription plan

        $response = Http::withBasicAuth(env("PAYMENT_SECRET_KEY"), '')
            ->get('https://api.moyasar.com/v1/payments/' . $_GET['id']);

        // Check response status and data
        if ($response->successful()) {

            $data = $response->json();
            // Handle the response data

            // read plan data 
            $planId     = Session::pull('plan_id'); // use ::pull to remove it not use ( ::get ...)
            $plan_data  = PlansModel::orderByDesc('created_at')->where('id', $planId)->first();
                       

            // create model object
            $payment                = new PaymentsModel();
            $payment->payment_id    = $data['id'];
            $payment->user_id       = $request->user()->id;
            $payment->amount        = doubleval($data['amount'] / 100);
            $payment->status        = $data['status'];
            $payment->description   = $plan_data['name']. ' - ' . $plan_data['billing_cycle'];
            

            // if payment not paid go to error page
            if($data['status'] == 'paid') 
            {
                if (isset($data['source'])) {
    
                    $payment->card_type     = $data['source']['company'];
                    $payment->card_digits   = $data['source']['number'];
    
                    if(isset($data['source']['token']))
                    {
                        // save card token
                        $card_token              = new CardsTokensModel();
                        $card_token->user_id     = $request->user()->id;
                        $card_token->card_token  = $data['source']['token'];
                        $card_token->card_digits = $data['source']['number'];
                        $card_token->company     = $data['source']['company'];
                        
                        $card_token->save(); // save card token
                    }
    
                }                
                
                $payment->save(); // save payment
                
                
                //save the subscription
                $subscription = new SubscriptionsModel();
                
                $end_date = Carbon::now()->addMonth();
                if(strcmp($plan_data['billing_cycle'] , 'yearly') == 0)
                {
                    $end_date = Carbon::now()->addYear();
                }
                
                $subscription->user_id      = $request->user()->id;
                $subscription->plan_id      = $planId;
                $subscription->start_date   = Carbon::today();
                $subscription->end_date     = $end_date;
                $subscription->status       = 'active';
                $subscription->save();
                
                Session::put('payment_id', $data['id'] );// save payment_id
                
                //redirect to success page
                return redirect()->route('payment.success');

            }else{      
                
                Session::put('payment_error', $data['source']['message'] ); // save the reason of faild payment
                
                //redirect to faild page
                return redirect()->route('payment.faild');

                //dd( $response->body() , $response->json() );
            }

        } else {
            // Handle the error
            // go to error page or 404 page
            $data    = $response->json();
            $message = $data["message"];

            Session::put( "payment_error" , $message ); // save the reason of faild payment
                
            //redirect to faild page
            return redirect()->route('payment.faild');

            //return $response->body();
            //dd( $response->body() , $response->json() );
        }
    }

    public function success(Request $request)
    {
        $payment_id    = Session::get('payment_id');
        return view('payments.success', compact('payment_id'));
    }

    public function faild(Request $request)
    {        
        $payment_error = Session::get('payment_error');
        return view('payments.faild' , compact('payment_error') );
    }

    // resetting the quota
    public function reset(Request $request)
    {
        /*
        $users = UsersModel::where('last_reset', '<=', Carbon::now()->subDays(30))
        // ->where('account_type' , 2)
        ->orWhereNull('last_reset')
        ->get();

        foreach ($users as $user) {
            $user->update([
                'items_added' => 0,
                'last_reset' => Carbon::now(),
            ]);
        }
        */

        $subscriptions = SubscriptionsModel::with('plan' , 'user')
        ->where('status', 'active')
        ->where('end_date', '<=', now())
        ->get();

        foreach ($subscriptions as $subscription) {
            $this->chargeUser($subscription);
        }

        return "Done!";
    }


    private function chargeUser($subscription)
    {
        // check if have token or not
        $user_id = $subscription->user_id;

        $card = CardsTokensModel::where('user_id' , $user_id)->first();

        if($card == null)
        {
            Log::error("User id: {$user_id} Don't have card to charge");
            return;
        }        
                

        try {

            $response = Http::withBasicAuth(env("PAYMENT_SECRET_KEY"), '')
            ->post('https://api.moyasar.com/v1/payments', [
                'amount' =>  $subscription->plan->price * 100, // in halalas
                'currency' => 'SAR',
                'source' => [
                    'type' => 'token',
                    'token' => $card->card_token,
                ],
                'description' => "Subscription renewal for {$subscription->plan->name}",
            ]);

            if ($response->successful()) {
                // get payment data to save it if paid
                $data = $response->json();
                
                // create model object
                $payment                = new PaymentsModel();
                $payment->payment_id    = $data['id'];
                $payment->user_id       = $user_id;
                $payment->amount        = doubleval($data['amount'] / 100);
                $payment->status        = $data['status'];
                $payment->description   = "Subscription renewal for - {$subscription->plan->name} | {$subscription->plan->billing_cycle}";
                
                $payment->save(); // save payment

                // if payment successful
                if($data['status'] == 'paid') 
                {
                    // update subscription dates
                    // get the plan billing cycle information
                    $subscription->start_date = now();
                    
                    if($subscription->plan->billing_cycle === 'monthly')
                    {
                        $subscription->end_date = now()->addMonth();
                    }else{
                        $subscription->end_date = now()->addYear();
                    }
                    
                    $subscription->save();
                    
                    Log::info("Renew completed, user id: ". $user_id);

                }else{
                    
                    Log::info("Payment Faild, user id: " . $user_id);

                }                

            } else {

                $data = $response->json();
                
                // Handle failed payment
                Log::info("can't renew the subscription, for user id: " . $user_id . " | reason : " . $data['message']);
            }

        } catch (\Exception $e) {
            // Log or handle the exception
            Log::error("renew error: {$e->getMessage()} ");
        }

    }

}
