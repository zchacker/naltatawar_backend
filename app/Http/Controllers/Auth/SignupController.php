<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    
    public function index(Request $request)
    {
        return view(('auth.signup'));
    }

    public function signup(Request $request)
    {
        $rules = [
            'name'      => 'required',
            'email'     => 'required|unique:users,email',
            'phone'     => 'required|unique:users,phone',
            'password'  => 'required',
        ];

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

            $password = $request->password;

            // update password set it as hashed one
            $request['password'] = Hash::make($request->password);
            $request['verified'] = 1;
            
            $code = random_int(100000, 999999);
            $request['code'] = $code;

            // create user account
            $user = UsersModel::create($request->all());

            /*
            $code = random_int(100000, 999999);

            // send email for verification
            Mail::send('emails.confirm_email', ['code' => $code], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject(' تأكيد البريد الالكتروني ');
            });
            */

            

            /*
            // set login cookies
            if (Auth::guard('agent')->attempt(['email' => $request->email, 'password' => $password], true)) {
                return redirect()->intended(route('subscriptions.packages'));// go to OTP page
            }
            */

            // save user data like email or id to verify it
            Session::put('user_email', $request['email'] );

            // redirect to otp screen
            // return redirect()->intended(route('auth.sign_up'));
            return redirect()->route('auth.otp.show');
            
        } else {

            $error     = $validator->errors();
            $allErrors = "";

            foreach ($error->all() as $err) {
                $allErrors .= $err . " <br/>";
            }

            return back()
                ->withErrors(['register_error' => $allErrors])
                ->withInput($request->all());
        }
    }


    public function show_otp(Request $request)
    {
        return view(('auth.verify')); // this for verification of email only, and not used to forgot password
    }

    public function confirm_otp(Request $request)
    {

        $rules = [
            'otp'  => 'required',
        ];

        $messages = [
            'otp.required' => __('otp_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails() == false) {

            // check otp with email            
            $email = Session::get("user_email" , NULL);

            if($email == NULL){                
                return redirect()->route('auth.sign_up');                
            }

            // get user from database
            $user = UsersModel::where('email' , $email)->first();

            if($user == NULL){

                return back()
                ->withErrors(['register_error' => __('unknown_error') ])
                ->withInput($request->all());

            } else {

                if($user->code === $request->otp)
                {

                    // Login as the target user
                    Auth::guard('client')->loginUsingId( $user->id ); 

                    // update the user to set it as email verfied 
                    $user->email_verified_at = now();
                    $user->code = NULL;
                    $user->save();

                    return redirect()->route('subscriptions.packages');// go to subscriptions page

                }else{
                    
                    return back()
                        ->withErrors(['register_error' => __('otp_wrong') ])
                        ->withInput($request->all());

                }

            }

        } else {

            $error     = $validator->errors();
            $allErrors = "";

            foreach ($error->all() as $err) {
                $allErrors .= $err . " <br/>";
            }

            return back()
                ->withErrors(['register_error' => $allErrors])
                ->withInput($request->all());

        }

    }

}
