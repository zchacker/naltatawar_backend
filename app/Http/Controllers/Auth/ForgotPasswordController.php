<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    // GET
    public function verify(Request $request)
    {
        return view('auth.verify');
    }

    public function verify_action(Request $request)
    {

    }

    // GET
    public function update_password(Request $request)
    {
        return view('auth.update_password');
    }

}
