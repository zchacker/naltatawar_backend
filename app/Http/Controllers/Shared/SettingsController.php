<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Auth\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function client_data(Request $request)
    {
        $user = UsersModel::with('subscription')->find($request->user()->id);
        return view('client.settings.profile', compact('user'));
    }

    public function client_agent_data(Request $request)
    {
        $user = UsersModel::with('avatar')->find($request->user()->id);
        return view('clients.settings.data', compact('user'));
    }  
    
    public function admin_data(Request $request)
    {
        $user = UsersModel::with('avatar')->find($request->user()->id);
        return view('admin.settings.data', compact('user'));
    }  
    
    public function supervisor_data(Request $request)
    {
        $user = UsersModel::with('avatar')->find($request->user()->id);
        return view('supervisor.settings.data', compact('user'));
    } 



    public function update_data_action(Request $request)
    {
        $user_id      = $request->user()->id;
        $profile_data = UsersModel::where(['id' => $user_id])->first();

        $rules = array(
            'name' => 'required',
            'email' => ['required',Rule::unique('users')->ignore($user_id)],
            'phone' => ['required',Rule::unique('users')->ignore($user_id)]            
        );

        $messages = [
            'name.required' => __('name_required'),
            'email.required' => __('email_required'),
            'email.unique' => __('email_unique'),
            'phone.required' => __('phone_required'), 
            'phone.unique'   => __('phone_unique'),            
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

            /*
            // check if there a file and this user is engineer
            if($profile_data->user_type == 'engineer') 
            {                
                if($request->hasFile('file'))
                {
                    $file_hash = hash_file('sha256', $request->file->getRealPath());
                    $fileDB    = FilesModel::where(['hash' => $file_hash])->first();                    

                    if ($fileDB == null) 
                    {

                        // store it in datebae
                        $fileName = $request->file('file')->getClientOriginalName() . '_' . time() . '.' . $request->file('file')->extension();

                        $url = $request->file('file')->storePublicly(
                            "avatar/images",
                            $this->basicStorage
                        );


                        if ($url == true) // file stored successfully
                        {
                            $file_added = FilesModel::create([
                                'fileName' => $url,
                                'hash' => $file_hash,
                                'storage_driver' => $this->basicStorage
                            ]);

                            // save it to database
                            $avtar = EngineerAvatarModel::where('user_id' , $request->user()->id);

                            if($avtar->count() == 0)// no data in database
                            {
                                $create_avtar = new EngineerAvatarModel();
                                $create_avtar->user_id = $request->user()->id;
                                $create_avtar->file_id = $file_added->id;
                                $create_avtar->save();
                            }else{
                                $avtar->file_id = $file_added->id;
                                $avtar->update();
                            }

                        }

                    } else {

                        // save it to database
                        // save it to database
                        $avtar = EngineerAvatarModel::where('user_id' , $request->user()->id);

                        if($avtar->count() == 0)// no data in database
                        {
                            $create_avtar = new EngineerAvatarModel();
                            $create_avtar->user_id = $request->user()->id;
                            $create_avtar->file_id = $fileDB->id;
                            $create_avtar->save();
                        }else{
                            $avtar->file_id = $fileDB->id;
                            $avtar->update([
                                'file_id' => $fileDB->id,
                            ]);
                        }

                    }
                }
            }
                       
            $profile_data->name = $request->name;
            $profile_data->name_en = $request->name_en;
            $profile_data->email = $request->email;
            $profile_data->phone = $request->phone;           

            if ($profile_data->update()) {
                
                return back()->with(['success' => __('updated_successfuly')]);

            } else {
                
                return back()->withErrors(['error' => __('unknown_error')]);

            }
            */
        }
    }

    public function update_password_action(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->withErrors(["error" => __('wrong-password')]);
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password same
            // return redirect()->back()->withErrors(["error" => "New Password cannot be same as your current password."]);
            return back()->with(['success' => __('updated_successfuly')]);
        }

        if(strcmp($request->get('new-password'), $request->get('re-password')) == 0){
            // re-password and new password not same            
            return back()->with(['success' => __('new_password_not_match')]);
        }
       

        //Change Password
        $user_id      = $request->user()->id;
        $profile_data = UsersModel::where(['id' => $user_id])->first();

        $profile_data->password = Hash::make($request->get('new-password'));  

        if ($profile_data->update()) {
                            
            // Auth::guard("engineer")->login( $profile_data );
            //auth()->login($request->user());
            //auth()->logoutOtherDevices($request->get('current-password'));

            Auth::logoutOtherDevices($request->get('current-password'));
            // Auth::login($request->user());

            return back()->with(['success' => __('updated_successfuly')]);

        } else {

            return back()->withErrors(['error' => __('unknown_error')]);                        

        }

    }
    

}
