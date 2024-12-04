<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    
    public function index(Request $request)
    {
        return view(('auth.signup'));
    }

    public function signup(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required',
        );

        $messages = [
            'name.required' => __('name_required'),
            'email.required' => __('email_required'),
            'email.unique' => __('email_unique'),
            'phone.required' => __('phone_required'),
            'phone.unique' => __('phone_unique'),
            'password.required' => __('password_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails() == false) {

            $password = $request->password;

            // update password set it as hashed one
            $request['password'] = Hash::make($request->password);
            $request['verified'] = 1;

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

            // set login cookies
            if (Auth::guard('agent')->attempt(['email' => $request->email, 'password' => $password], true)) {
                return redirect()->intended(route('subscriptions.packages'));// go to OTP page
            }

            return redirect()->intended(route('auth.sign_up'));
            
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
