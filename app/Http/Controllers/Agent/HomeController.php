<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property\PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        if ($request->user()->parent()->subscription === null) {
            return redirect()->route('subscriptions.packages');
        }

        //abort(Response::HTTP_UNAUTHORIZED);        

        $user_id = $request->user()->parent()->id;

        $properties  = PropertyModel::where('user_id', $request->user()->parent()->id)->limit(10)->get();

        $total  = PropertyModel::where('user_id', $user_id)        
        ->count();

        $sell_count = PropertyModel::where('user_id', $user_id)
        ->whereIn('purpose', [25, 38])
        ->count();

        $invest_count = PropertyModel::where('user_id', $user_id)
        ->whereIn('purpose', [27, 36])
        ->count();

        $rent_count = PropertyModel::where('user_id', $user_id)
        ->whereIn('purpose', [26, 34])
        ->count();

        return view('agent.home', compact('properties', 'total' , 'sell_count', 'invest_count', 'rent_count'));
    }
    
}
