<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function client_logout(Request $request)
    {
        if (Auth::guard('client')->check()) // this means that the clients was logged in.
        {
            Auth::guard('client')->logout();
            $request->session()->flush();
            return redirect()->route('login');
        }
    }

    public function agent_logout(Request $request)
    {
        if (Auth::guard('agent')->check()) // this means that the agents was logged in.
        {
            Auth::guard('agent')->logout();
            $request->session()->flush();
            return redirect()->route('login');
        }
    }

    public function admin_logout(Request $request)
    {
        if (Auth::guard('admin')->check()) // this means that the admins was logged in.
        {
            Auth::guard('admin')->logout();
            $request->session()->flush();
            return redirect()->route('login');
        }
    }
    
}
