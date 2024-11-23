<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Payments\CardsTokensModel;
use App\Models\Payments\PaymentsModel;
use App\Models\Subscription\PlansModel;
use App\Models\Subscription\SubscriptionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
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
            $price = $query->price * 100;
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

        $response = Http::withBasicAuth('sk_test_YkBSaYiZ5FXZP3DbZxzJDqVg2hQmu2PVZ3ZRmo5T', '')
            ->get('https://api.moyasar.com/v1/payments/' . $_GET['id']);

        // Check response status and data
        if ($response->successful()) {

            $data = $response->json();
            // Handle the response data

            // if payment not paid go to error page
            if($data['status'] != 'paid') 
            {
                dd("Payment not paid");
            }

            // create model object
            $payment = new PaymentsModel();
            $payment->payment_id = $data['id'];
            $payment->user_id    = $request->user()->id;
            $payment->amount     = doubleval($data['amount'] / 100);
            $payment->status     = $data['status'];

            if (isset($data['source'])) {

                $payment->card_type     = $data['source']['company'];
                $payment->card_digits   = $data['source']['number'];

                // save card token
                $card_token              = new CardsTokensModel();
                $card_token->user_id     = $request->user()->id;
                $card_token->card_token  = $data['source']['token'];
                $card_token->card_digits = $data['source']['number'];

                $card_token->save(); // save card token

            }

            $payment->save(); // save payment

            // read plan data 
            $planId    = Session::pull('plan_id'); // use ::pull to remove it not use ( ::get ...)
            $plan_data = PlansModel::orderByDesc('created_at')->where('id', $planId)->first();
            
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

            //return $data;
            //dd($data, $request->user()->id);
        } else {
            // Handle the error
            // go to error page or 404 page
            //return $response->body();
            dd($response->body());
        }
    }


    public function success(Request $request)
    {
        $payment_id    = Session::get('payment_id');
        return view('payments.success', compact('payment_id'));
    }
}
