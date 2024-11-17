<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    public function index(Request $request)
    {
        return view('subscriptions.packages');
    }
}
