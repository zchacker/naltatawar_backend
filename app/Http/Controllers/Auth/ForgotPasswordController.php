<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    
    public function index(Request $request)
    {
        return view(('auth.forgot_password'));
    }

    // POST
    public function forgot_password(Request $request)
    {

    }

    // this for link in emails
    public function verify(Request $request)
    {

        if ($request->get('id')) {
            // print 'has id';
        }

        if (strlen($request->id) > 0 && strlen($request->token) > 0) {

            $id      = $request->id;
            $token   = $request->token;
            $isFound =  DB::table('password_resets')
                ->where(['id' => $id, 'token' => $token])
                // ->where('id'    , '=' , $id)
                // ->where('token' , '=' , $token)
                ->count();

            if ($isFound == 0) {
                return abort(Response::HTTP_NOT_FOUND, "Not found");
            }

            return view('auth.update_password', compact('id', 'token'));

        } else {

            return abort(Response::HTTP_NOT_FOUND, "Not found");
        }
    }
    

    // POST
    public function update_password(Request $request)
    {
        if (strlen($request->id) > 0 && strlen($request->token) > 0) {

            $id             = $request->id;
            $token          = $request->token;
            $reset_data     = DB::table('password_resets')
                            ->where(['id' => $id, 'token' => $token]);

            if ($reset_data->count() == 0) {

                return abort(Response::HTTP_NOT_FOUND, "Not found");
            
            } else {

                $rules = array(
                    'password' => 'required',
                    're-password' => 'required'
                );

                $messages = [
                    'password.required' => __('password_required'),
                    're-password.required' => __('re-password_required')
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails() == true) {

                    $error     = $validator->errors();
                    $allErrors = "";

                    foreach ($error->all() as $err) {
                        $allErrors .= $err . " <br/>";
                    }

                    return back()->withErrors(['error' => $allErrors]);
                    
                } else {

                    if (strcmp($request->password, $request->get('re-password')) != 0) {

                        return back()->withErrors(['error' => __('password-not-match')]);
                    }

                    $data = $reset_data->first();
                    $profile_data = UsersModel::where(['email' => $data->email])->first();

                    $profile_data->password = Hash::make($request->get('password'));

                    if ($profile_data->update()) {

                        DB::table('password_resets')->where(['email' => $data->email])->delete();
                        return redirect(route('auth.login'))->with(['success' => __('password_updated')]);
                        
                    } else {

                        return back()->withErrors(['error' => __('unknown_error')]);
                    }
                }
            }

        } else {

            return back()->withErrors(['error' => __('unknown_error')]);

        }
    }

}
