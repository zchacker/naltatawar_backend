<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function agent_logout(Request $request)
    {
        if (Auth::guard('client')->check()) // this means that the admins was logged in.
        {
            Auth::guard('client')->logout();
            $request->session()->flush();
            return redirect()->route('login');
        }
    }
}
