<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function home(Request $request)
    {

        if($request->user()->subscription === null)
        {
            return redirect()->route('subscriptions.packages');
        }
        return view('client.home');
    }

}
