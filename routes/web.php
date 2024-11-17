<?php

use Illuminate\Support\Facades\Route;

// from start set default locale 
App::setLocale('ar');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/', function(){
    return view('test');
});

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('auth.login');
Route::post('/login/action', [\App\Http\Controllers\Auth\LoginController::class, 'login_action'])->name('auth.login.action');

Route::get('/sign_up', [\App\Http\Controllers\Auth\SignupController::class, 'index'])->name('auth.sign_up');
Route::post('/sign_up/action', [\App\Http\Controllers\Auth\SignupController::class, 'signup'])->name('auth.sign_up.action');

Route::get('/forgot_password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('auth.forgot_password');
Route::get('/verify_otp', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'verify'])->name('auth.verify');
Route::get('/update_password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'update_password'])->name('auth.update_password');

Route::get('/subscriptions', [\App\Http\Controllers\Subscriptions\PackagesController::class, 'index'])->name('subscriptions.packages');


Route::get('/payment/success', [\App\Http\Controllers\Subscriptions\PaymentController::class, 'index'])->name('payment.success');