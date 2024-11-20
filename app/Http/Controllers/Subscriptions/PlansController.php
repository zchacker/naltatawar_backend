<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Subscription\PlansModel;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index(Request $request)
    {
        $monthly_individual = PlansModel::orderByDesc('created_at')->where('billing_cycle', 'monthly')->where('plan_type' , 'individuals')->get(); 
        $yearly_individual  = PlansModel::orderByDesc('created_at')->where('billing_cycle', 'yearly')->where('plan_type' , 'individuals')->get(); 
        
        $monthly_businesses = PlansModel::orderByDesc('created_at')->where('billing_cycle', 'monthly')->where('plan_type' , 'businesses')->get(); 
        $yearly_businesses  = PlansModel::orderByDesc('created_at')->where('billing_cycle', 'yearly')->where('plan_type' , 'businesses')->get(); 
                
        return view('subscriptions.plans', compact('monthly_individual', 'yearly_individual', 'monthly_businesses', 'yearly_businesses'));
    }
}
