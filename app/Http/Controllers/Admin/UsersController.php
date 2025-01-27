<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\UsersModel;
use App\Models\Payments\PaymentsModel;
use App\Models\Subscription\PlansModel;
use App\Models\Subscription\SubscriptionsModel;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function home(Request $request)
    {    
        $query      = UsersModel::where('account_type', 2);

        if ($request->filled('query'))
        {
            $searchTerm = $request->input('query');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                ->orWhere('phone', 'LIKE', "%{$searchTerm}%");
            });
        }

        $sum        = $query->count('id');
        $contacts   = $query->paginate(100);

        return view('admin.users.list', compact('contacts', 'sum'));
    }

    public function create_form(Request $request)
    {
        return view('admin.users.create');
    }

    public function create_action(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = UsersModel::where('email', $value)
                        ->where('parent', '!=', $request->user()->id)
                        ->exists();
                    if ($exists) {
                        $fail(__('email_unique'));
                    }
                },
            ],
            'phone' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = UsersModel::where('phone', $value)
                        ->where('parent', '!=', $request->user()->id)
                        ->exists();
                    if ($exists) {
                        $fail(__('phone_unique'));
                    }
                },
            ],
            'password' => 'required',
        ];

        $messages = [
            'name.required' => __('name_required'),
            'email.required' => __('email_required'),
            'phone.required' => __('phone_required'),
            'password.required' => __('password_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) 
        {
            $error      = $validator->errors();
            $allErrors  = "";

            foreach ($error->all() as $err) {
                $allErrors .= "<li>" . $err . "</li>";
            }

            return back()
                ->withErrors(['error' => $allErrors])
                ->withInput($request->all());
        }

        // Check for a soft-deleted user with the same email or phone under the same parent
        $existingUser = UsersModel::onlyTrashed()
            ->where('email', $request->email)
            ->where('parent', $request->user()->id)
            ->orWhere(function ($query) use ($request) {
                $query->where('phone', $request->phone)
                    ->where('parent', $request->user()->id);
            })
            ->first();

        if ($existingUser) {
            // Restore the user and update other data if needed
            $existingUser->restore();
            $existingUser->update([
                'name' => $request->name,
                'account_type' => $request->account_type,
                'password' => Hash::make($request->password),
            ]);

            return back()->with(['success' => __('added_successfuly')]);//user_restored_successfully
        }

        // Create a new user
        $password = Hash::make($request->password);

        $add_real_estate      = $request->has('add_real_estate') ? true : false;
        $edit_real_estate     = $request->has('edit_real_estate') ? true : false;
        $delete_real_estate   = $request->has('delete_real_estate') ? true : false;
        $billing              = $request->has('billing') ? true : false;
        $can_show_contact     = $request->has('can_show_contact') ? true : false;

        // Create JSON data
        $jsonData = [
            'add_real_estate' => $add_real_estate,
            'edit_real_estate' => $edit_real_estate,
            'delete_real_estate' => $delete_real_estate,
            'billing' => $billing,
            'can_show_contact' => $can_show_contact,
        ];

        $user = UsersModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'account_type' => $request->account_type,            
            'parent' => $request->user()->id,
            'email_verified_at' => Carbon::now(),
            'permissions' => NULL // $jsonData
        ]);

        if ($user) {
            return back()->with(['success' => __('added_successfuly')]);
        } else {
            return back()
                ->withErrors(['error' => __('faild_to_save')])
                ->withInput($request->all());
        }
    }


    public function edit_form(Request $request)
    {
        $data = UsersModel::where('id', $request->id)->first();

        if ($data === null) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        // 1 - show his payment list
        // 2 - show his last subscription

        // payments
        $query      = PaymentsModel::where(['user_id' => $data->id , 'status' => 'paid']);
        $sum        = $query->count('id');
        $payments   = $query->paginate(100);

        // subscription
        $subscription = SubscriptionsModel::where("user_id", $data->id)->first();
        $plans         = PlansModel::all();

        return view('admin.users.edit', compact('data' , 'payments', 'subscription', 'plans'));
    }

    public function edit_action(Request $request)
    {
        $rules = array(
            'name'     => 'required',
            'email'    => ['required', Rule::unique('users')->ignore($request->id)],
            'phone'    => ['required', Rule::unique('users')->ignore($request->id)],
            // 'password' => 'required',
        );

        $messages = [
            'name.required'     => __('name_required'),
            'email.required'    => __('email_required'),
            'email.unique'      => __('email_unique'),
            'phone.required'    => __('phone_required'),
            'phone.unique'      => __('phone_unique'),
            'password.required' => __('password_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails() == false) {


            $password   = Hash::make($request->password);

            $add_real_estate      = $request->has('add_real_estate') ? true : false;
            $edit_real_estate     = $request->has('edit_real_estate') ? true : false;
            $delete_real_estate   = $request->has('delete_real_estate') ? true : false;
            $billing              = $request->has('billing') ? true : false;
            $can_show_contact     = $request->has('can_show_contact') ? true : false;

            // Create JSON data
            $jsonData = [
                'add_real_estate' => $add_real_estate,
                'edit_real_estate' => $edit_real_estate,
                'delete_real_estate' => $delete_real_estate,
                'billing' => $billing,
                'can_show_contact' => $can_show_contact,
            ];

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,                
                'account_type' => 3,
                'parent' => $request->user()->id,
                //'email_verified_at' => Carbon::now(),
                //'permissions' => $jsonData
            ];

            if ($request->filled('password')) {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $password,
                    'account_type' => 3,
                    'parent' => $request->user()->id,
                    //'email_verified_at' => Carbon::now(),
                    //'permissions' => $jsonData
                ];
            }

            $user = UsersModel::where('id', $request->id)->update($data);


            if ($user) {
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


    public function delete(UsersModel $user)
    {
        $user->delete();
        return redirect()->route('admin.users.home');
    }

    // Start impersonation
    public function impersonate($userId)
    {
        if (Auth::guard('admin')->check()) 
        {
            // Save current admin session
            session()->put('impersonate', Auth::guard('admin')->id());

            // Login as the target user
            Auth::guard('client')->loginUsingId($userId);            

            return redirect(route('client.home'))->with('success', 'You are now impersonating the user.');
        }

        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Stop impersonation
    public function stopImpersonation(Request $request)
    {
        if (session()->has('impersonate')) 
        {
            // get current user id
            $user_id = Auth::guard('client')->user()->id;

            // Get the original super admin ID
            $superAdminId = session()->get('impersonate');

            // Logout the current user
            Auth::guard('client')->logout();            

            // Login back as super admin
            Auth::guard('admin')->loginUsingId($superAdminId);

            // Remove impersonation session
            session()->forget('impersonate');

            return redirect(route('admin.users.edit.form' , $user_id))->with('success', __('back_to_original_account') );
        }

        return redirect()->back()->with('error', 'No impersonation session found.');
    }


    // update user subcription date & plan
    public function update_user_subcription(Request $request)
    {


        $rules = [
            // 'estimated_date' => 'date_format:Y-m-d',
            'end_date' => 'required|after_or_equal:today',//   . now()->toDateString(),
        ];
        
        $messages = [
            'end_date.after_or_equal'  => __('after_or_equal'),            
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails() == false) {
                        
            $data = [
                'end_date'  => $request->end_date,
                'plan_id'   => $request->plan,
                // 'phone' => $request->phone,                
            ];        
    
            $user = SubscriptionsModel::where('user_id', $request->id)->update($data);
    
            if ($user) {
    
                return back()->with(['success' => __('subscription_updated_successfuly')]);
    
            } else {
    
                
                return back()
                ->withErrors(['error' => __('faild_to_save')])
                ->withInput($request->all());
            
            }

        }else{                    

            $error     = $validator->errors();
            $allErrors = "";

            // dd($error);
            
            foreach ($error->all() as $err) {
                $allErrors .= "<li>" . $err . "</li>";
            }

            return back()
                ->withErrors(['error' => $allErrors])
                ->withInput($request->all());

        }                

    }

}
