<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Subscription\PlansModel;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function pay(Request $request)
    {
        $query = PlansModel::orderByDesc('created_at')->where('id', $request->plan)->first();         
        $price = 0;
        $name = 0;
        if($query)
        {
            $name  = $query->name;
            $price = $query->price * 100;
        }        

        //dd($price);

        return view('payments.pay', compact('price', 'name'));
    }


    public function success(Request $request)
    {
        return view('payments.success');
    }

}
