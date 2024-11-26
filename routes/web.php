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

// Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('auth.login');
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('/login/action', [\App\Http\Controllers\Auth\LoginController::class, 'login_action'])->name('auth.login.action');

Route::get('/sign_up', [\App\Http\Controllers\Auth\SignupController::class, 'index'])->name('auth.sign_up');
Route::post('/sign_up/action', [\App\Http\Controllers\Auth\SignupController::class, 'signup'])->name('auth.sign_up.action');

Route::get('/forgot_password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('auth.forgot_password');
Route::get('/resetpassword/{id}/{token}', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('auth.forgot_password');


Route::get('/verify_otp', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'verify'])->name('auth.verify');
Route::get('/update_password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'update_password'])->name('auth.update_password');


Route::group(['middleware' => ['auth:agent']], function () {
    
    // after login or registration
    Route::get('/subscriptions', [\App\Http\Controllers\Subscriptions\PlansController::class, 'index'])->name('subscriptions.packages');
    Route::get('/payment/pay/{plan}', [\App\Http\Controllers\Subscriptions\PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/callback', [\App\Http\Controllers\Subscriptions\PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/success', [\App\Http\Controllers\Subscriptions\PaymentController::class, 'success'])->name('payment.success');
    
    // home dashboard
    Route::get('/home', [\App\Http\Controllers\Client\HomeController::class, 'home'])->name('client.home');
    
    // real estate
    Route::get('/home', [\App\Http\Controllers\Client\HomeController::class, 'home'])->name('client.home');
    Route::get('/home', [\App\Http\Controllers\Client\HomeController::class, 'home'])->name('client.home');
    Route::get('/home', [\App\Http\Controllers\Client\HomeController::class, 'home'])->name('client.home');
    

    // contact requests    
    Route::get('/contacts/home', [\App\Http\Controllers\Client\ContactRequestController::class, 'home'])->name('client.contacts.home');
    Route::get('/contacts/details/{id}', [\App\Http\Controllers\Client\ContactRequestController::class, 'details'])->name('client.contacts.details');
    
    //users
    Route::get('/users/home', [\App\Http\Controllers\Client\UsersController::class, 'home'])->name('client.users.home');
    Route::get('/users/create', [\App\Http\Controllers\Client\UsersController::class, 'create_form'])->name('client.users.create.form');
    Route::post('/users/create/action', [\App\Http\Controllers\Client\UsersController::class, 'create_action'])->name('client.users.create.action');
    
    Route::get('/users/edit/{id}', [\App\Http\Controllers\Client\UsersController::class, 'edit_form'])->name('client.users.edit.form');
    Route::post('/users/edit/{id}/action', [\App\Http\Controllers\Client\UsersController::class, 'edit_action'])->name('client.users.edit.action');
    
    Route::delete('/users/delete/{user}', [\App\Http\Controllers\Client\UsersController::class, 'delete'])->name('client.users.delete.action');
    
    
    Route::get('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'agent_logout'])->name('client.logout');
});
