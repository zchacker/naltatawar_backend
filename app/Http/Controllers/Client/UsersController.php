<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Auth\UsersModel;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function home(Request $request)
    {
        $max_user   = $request->user()->subscription->plan->user;
        $query      = UsersModel::where('parent', $request->user()->id);
        $sum        = $query->count('id');
        $contacts   = $query->paginate(100);

        return view('client.users.list', compact('contacts', 'max_user', 'sum'));
    }

    public function create_form(Request $request)
    {
        return view('client.users.create');
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

        if ($validator->fails()) {
            $error = $validator->errors();
            $allErrors = "";

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
            'account_type' => 3,
            'parent' => $request->user()->id,
            'email_verified_at' => Carbon::now(),
            'permissions' => $jsonData
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

        return view('client.users.edit', compact('data'));
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
                'password' => $password,
                'account_type' => 3,
                'parent' => $request->user()->id,
                'email_verified_at' => Carbon::now(),
                'permissions' => $jsonData
            ];

            if ($request->filled('password')) {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'account_type' => 3,
                    'parent' => $request->user()->id,
                    'email_verified_at' => Carbon::now(),
                    'permissions' => $jsonData
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
        return redirect()->route('client.users.home');
    }
}
