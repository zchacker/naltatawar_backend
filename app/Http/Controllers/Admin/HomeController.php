<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\UsersModel;
use App\Models\Client\ContactRequestsModel;
use App\Models\Property\PropertyModel;
use App\Models\Subscription\SubscriptionsModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function home(Request $request)
    {
        
        $properties     = PropertyModel::limit(10)->get();
        $total          = PropertyModel::count();

        $sell_count     = PropertyModel::whereIn('purpose', [25, 38])
        ->count();

        $invest_count   = PropertyModel::whereIn('purpose', [27, 36])
        ->count();

        $rent_count     = PropertyModel::whereIn('purpose', [26, 34])
        ->count();

        $subscribers_count      = UsersModel::where('account_type', 2)->count();
        $users_count            = UsersModel::whereIn('account_type', [2,3])->count();
        $active_subscriptions   = SubscriptionsModel::where('status', 'active')->count();        
        $inactive_subscriptions = SubscriptionsModel::whereIn('status', ['expired' , 'cancelled'])->count();
        $contact_requests       = ContactRequestsModel::count();

        return view('admin.home', compact('properties',
            'total' ,
            'sell_count',
            'invest_count',
            'rent_count',
            'subscribers_count',
            'users_count',
            'active_subscriptions',
            'inactive_subscriptions',
            'contact_requests'
        ));
    
    }
    
}
