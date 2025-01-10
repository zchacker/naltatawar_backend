<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\UsersModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        //$currentPath = $request->path();
        //$page   = PagesModel::where('path' , 'like',  '%' . $currentPath . '%')->first(); 
        //return view('auth.login', compact('page'));
        return view('auth.login');
    }

    public function login_action(Request $request)
    {
        $rules = array(
            'email'    => 'required',
            'password' => 'required',
        );

        $messages = [
            'email.required'    => __('email_required'),
            'password.required' => __('password_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // dd('hello');

        if ($validator->fails() == false) {
            $debug = "user";
            try {

                // looking for email if exists
                $user = UsersModel::withTrashed()
                ->where('email', '=', $request->email)
                ->first();                                               

                if ($user) {       
                    
                    // this should appear if usr not null
                    if ($user->deleted_at !== null) {
                        // Account soft deleted
                        
                        // Redirect with a message indicating that the account is deleted                    
                        return back()
                        ->withErrors(['login_error' => __('account_deleted')])
                        ->withInput($request->all());                            
                    }

                    $user_type = 'admin';

                    switch($user->account_type)
                    {
                        case 1:
                            $user_type = 'admin';
                            break;
                        case 2:
                            $user_type = 'client';
                            break;
                        case 3:
                            $user_type = 'agent';
                            break;
                        case 4:
                            $user_type = 'support';
                            break;
                        default:
                            $user_type = 'admin';                        
                    }

                    if (Auth::guard($user_type)->attempt(['email' => $request->email, 'password' => $request->password], true)) {
                        
                        // Auth::guard($user_type)->logoutOtherDevices( $request->password );
                                                                    
                        switch ($user_type) {
                            
                            case "admin":                                
                                return redirect()->intended(route('admin.home'));                                
                                break;
                            case "client":                                                       
                                return redirect()->intended(route('client.home'));                                
                                break;
                            case "agent":                                                                
                                return redirect()->intended(route('agent.home'));                                
                                break;
                            case "support":
                                return redirect()->intended(route('client.home'));                                
                                break;                           
                            default:
                                return redirect()->intended(route('subscriptions.packages'));                                
                        }
                                                
                        return redirect()->route('subscriptions.packages');

                    } else {                                            

                        return back()
                            ->withErrors(['login_error' => __('worng_password')])
                            ->withInput($request->all());
                    }
                    
                } else {

                    return back()
                        ->withErrors(['login_error' => __('worng_password')])
                        ->withInput($request->all());
                }

            } catch (Exception $ex) {
                
                return back()
                    ->withErrors(['login_error' => __('unknown_error').' '.$ex->getMessage().' '.$ex->getCode()])
                    ->withInput($request->all());

            }

        } else {

            $error     = $validator->errors();
            $allErrors = "";

            foreach ($error->all() as $err) {
                $allErrors .= $err . " <br/>";
            }

            return back()
                ->withErrors(['login_error' => $allErrors])
                ->withInput($request->all());

        }
    }

}
