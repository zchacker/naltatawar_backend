<?php

namespace App\Console\Commands;

use App\Models\Payments\CardsTokensModel;
use App\Models\Payments\PaymentsModel;
use App\Models\Subscription\SubscriptionsModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChargeSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:charge-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $subscriptions = SubscriptionsModel::with('plan' , 'user')
        ->where('status', 'active')
        ->where('end_date', '<=', now())
        ->get();

        foreach ($subscriptions as $subscription) {
            $this->chargeUser($subscription);
        }

        $this->info("Subscriptions successfully charged");
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
                $payment->card_type     = $data['source']['company'];
                $payment->card_digits   = $data['source']['number'];
                
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
                    
                    Log::info("Renew completed, user id: {$user_id}");

                }else{                    
                    Log::info("Payment Faild, user id: {$user_id}");
                }                

            } else {

                $data = $response->json();
                
                // Handle failed payment
                Log::info("can't renew the subscription, for user id: {$user_id} | reason : {$data['message']} ");
            }

        } catch (\Exception $e) {
            // Log or handle the exception
            Log::error("renew error: {$e->getMessage()} ");
        }
        
    }

}
