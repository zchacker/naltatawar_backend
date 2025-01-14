<?php

namespace App\Http\Controllers\Admin\Billing;

use App\Http\Controllers\Controller;
use App\Models\Subscription\PlansModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlansController extends Controller
{
    
    public function list(Request $request)
    {
        $individuals_query  = PlansModel::where("plan_type" , "individuals" );
        $businesses_query   = PlansModel::where("plan_type" , "businesses" );
        
        $sum                = $individuals_query->count('id');
        $sum                = $businesses_query->count('id');

        $individuals        = $individuals_query->limit(100)->get();        
        $businesses         = $businesses_query->limit(100)->get();
        
        return view('admin.plans.list', compact('individuals' , 'businesses' , 'sum'));
    }

    public function edit(Request $request)
    {
        $data = PlansModel::where('id', $request->id)->first();

        if ($data === null) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        return view('admin.plans.edit', compact('data'));
    }

    public function edit_action(Request $request)
    {
        $rules = array(
            'name'     => 'required',
            'price'     => 'required',
            'items'     => 'required',
            'user'     => 'required',
            'billing_cycle'     => 'required',
            'plan_type'     => 'required',
            // 'password' => 'required',
        );

        $messages = [
            'name.required'         => __('name_required'),
            'price.required'        => __('price_required'),
            'items.required'        => __('items_required'),
            'user.required'         => __('user_required'),
            'billing_cycle.required'  => __('billing_cycle_required'),
            'plan_type.required'    => __('plan_type_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails() == false) {
            
            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'items' => $request->items,                
                'user' => $request->user,                
                'billing_cycle' => $request->billing_cycle,                
                'plan_type' => $request->plan_type,                 
            ];            

            $plan = PlansModel::where('id', $request->id)->update($data);

            if ($plan) {
                return back()->with(['success' => __('updated_successfuly')]);
            } else {
                return back()
                    ->withErrors(['error' => __('faild_to_save')])
                    ->withInput($request->all());
            }

        } else {

            $error     = $validator->errors();
            $allErrors = "";

            foreach ($error->all() as $err) {
                $allErrors .= "<li>" . $err . "</li>";
            }

            return back()
                ->withErrors(['error' => $allErrors])
                ->withInput($request->all());

        }
    }

}
