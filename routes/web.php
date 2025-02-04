<?php

use Illuminate\Support\Facades\Route;

// from start set default locale 
App::setLocale('ar');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/', function(){
    return view('auth.verify');
});

Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('home');

// Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('auth.login');
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('/login/action', [\App\Http\Controllers\Auth\LoginController::class, 'login_action'])->name('auth.login.action');

Route::get('/sign_up', [\App\Http\Controllers\Auth\SignupController::class, 'index'])->name('auth.sign_up');
Route::post('/sign_up/action', [\App\Http\Controllers\Auth\SignupController::class, 'signup'])->name('auth.sign_up.action');

Route::get('/forgot_password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('auth.forgot_password');
Route::get('/resetpassword/{id}/{token}', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('auth.forgot_password');

Route::get('/verify-email', [\App\Http\Controllers\Auth\SignupController::class, 'show_otp'])->name('auth.otp.show');
Route::post('/verify-otp', [\App\Http\Controllers\Auth\SignupController::class, 'confirm_otp'])->name('auth.otp.confirm');
Route::post('/resent-otp', [\App\Http\Controllers\Auth\SignupController::class, 'resend_otp'])->name('auth.otp.resend');


Route::get('/verify_otp', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'verify'])->name('auth.verify');
Route::get('/update_password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'update_password'])->name('auth.update_password');


Route::group(['middleware' => ['auth:admin'] , 'prefix' => 'admin'], function () { 

    // home dashboard
    Route::get('/home', [\App\Http\Controllers\Admin\HomeController::class, 'home'])->name('admin.home');
    
    // real estate
    Route::get('/properties', [\App\Http\Controllers\Admin\PropertyController::class, 'list'])->name('admin.property.list');
    Route::get('/properties/my', [\App\Http\Controllers\Admin\PropertyController::class, 'my_list'])->name('admin.property.list.my');
    Route::get('/properties/edit/{id}', [\App\Http\Controllers\Admin\PropertyController::class, 'edit'])->name('admin.property.edit');
    Route::post('/properties/publish', [\App\Http\Controllers\Admin\PropertyController::class, 'publish_properity'])->name('admin.property.publish');

    Route::get('/properties/create', [\App\Http\Controllers\Admin\PropertyController::class, 'create'])->name('admin.property.create');
    Route::post('/properties/create/action', [\App\Http\Controllers\Admin\PropertyController::class, 'create_action'])->name('admin.property.create.action');
    Route::get('/properties/edit/{id}', [\App\Http\Controllers\Admin\PropertyController::class, 'edit'])->name('admin.property.edit');
    Route::post('/properties/edit/action/{id}', [\App\Http\Controllers\Admin\PropertyController::class, 'edit_action'])->name('admin.property.edit.action');
    
    Route::delete('/properties/delete/{property}', [\App\Http\Controllers\Admin\PropertyController::class, 'delete'])->name('admin.property.delete');
    
    Route::post('/file/upload', [\App\Http\Controllers\Admin\PropertyController::class, 'uploadLargeFiles'])->name('admin.property.file.upload');    

    // contact requests    
    Route::get('/contacts/home', [\App\Http\Controllers\Admin\ContactRequestController::class, 'home'])->name('admin.contacts.home');
    Route::get('/contacts/details/{id}', [\App\Http\Controllers\Admin\ContactRequestController::class, 'details'])->name('admin.contacts.details');    
    
    //users
    Route::get('/users/home', [\App\Http\Controllers\Admin\UsersController::class, 'home'])->name('admin.users.home');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UsersController::class, 'create_form'])->name('admin.users.create.form');
    Route::post('/users/create/action', [\App\Http\Controllers\Admin\UsersController::class, 'create_action'])->name('admin.users.create.action');
    
    Route::get('/users/edit/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'edit_form'])->name('admin.users.edit.form');
    Route::post('/users/edit/{id}/action', [\App\Http\Controllers\Admin\UsersController::class, 'edit_action'])->name('admin.users.edit.action');
    
    Route::delete('/users/delete/{user}', [\App\Http\Controllers\Admin\UsersController::class, 'delete'])->name('admin.users.delete.action');
    
    // this is login as other users
    Route::get('/impersonate/{userId}', [\App\Http\Controllers\Admin\UsersController::class, 'impersonate'])->name('admin.users.impersonate');
    Route::get('/stop-impersonate', [\App\Http\Controllers\Admin\UsersController::class, 'stopImpersonation'])->name('admin.users.stop.impersonate');
    // update user subscriotion
    Route::post('/subcription/update/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'update_user_subcription'])->name('admin.users.subcription.update');
    
    // payments
    Route::get('/payments/list', [\App\Http\Controllers\Admin\Billing\PaymentsController::class, 'payments'])->name('admin.payments');
    Route::get('/payments/invoice/{id}', [\App\Http\Controllers\Admin\Billing\PaymentsController::class, 'invoice'])->name('admin.invoice');
    
    // plans
    Route::get('/plans/list', [\App\Http\Controllers\Admin\Billing\SubscriptionPlansController::class, 'list'])->name('admin.plans.list');
    Route::get('/plan/edit/{id}', [\App\Http\Controllers\Admin\Billing\SubscriptionPlansController::class, 'edit'])->name('admin.plan.edit');
    Route::post('/plan/edit/{id}', [\App\Http\Controllers\Admin\Billing\SubscriptionPlansController::class, 'edit_action'])->name('admin.plan.edit.action');

    // support
    Route::get('/support/list', [\App\Http\Controllers\Admin\SupportController::class, 'list'])->name('admin.support.list');
    Route::get('/support/create', [\App\Http\Controllers\Admin\SupportController::class, 'create'])->name('admin.support.create');
    Route::post('/support/create/action', [\App\Http\Controllers\Admin\SupportController::class, 'create_action'])->name('admin.support.create.action');
    Route::get('/support/update/{id}', [\App\Http\Controllers\Admin\SupportController::class, 'update'])->name('admin.support.update');
    Route::post('/support/update/action/{id}', [\App\Http\Controllers\Admin\SupportController::class, 'update_action'])->name('admin.support.update.action');
    

    // settings
    Route::get('/settings', [\App\Http\Controllers\Shared\SettingsController::class, 'admin_data'])->name('admin.settings');
    Route::post('/settings/update/profile', [\App\Http\Controllers\Shared\SettingsController::class, 'update_data_action'])->name('admin.settings.update.profile');
    Route::post('/settings/update/password', [\App\Http\Controllers\Shared\SettingsController::class, 'update_password_action'])->name('admin.settings.update.password');


    // logout
    Route::get('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'admin_logout'])->name('admin.logout');
    
});

Route::group(['middleware' => ['auth:client']], function () {
    
    // after login or registration
    Route::get('/subscriptions', [\App\Http\Controllers\Subscriptions\PlansController::class, 'index'])->name('subscriptions.packages');
    Route::get('/payment/pay/{plan}', [\App\Http\Controllers\Subscriptions\PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/callback', [\App\Http\Controllers\Subscriptions\PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/success', [\App\Http\Controllers\Subscriptions\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/faild', [\App\Http\Controllers\Subscriptions\PaymentController::class, 'faild'])->name('payment.faild');
    
    // home dashboard
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
    
    // payments
    Route::get('/payments/list', [\App\Http\Controllers\Client\Billing\PaymentsController::class, 'payments'])->name('client.payments');
    Route::post('/payments/update/subscription', [\App\Http\Controllers\Client\Billing\PaymentsController::class, 'update_subscription_status'])->name('client.update.subscription.status');
    Route::get('/payments/invoice/{id}', [\App\Http\Controllers\Client\Billing\PaymentsController::class, 'invoice'])->name('client.invoice');
    Route::get('/cards/list', [\App\Http\Controllers\Client\Billing\PaymentsController::class, 'list_cards'])->name('client.card.list');
    Route::delete('/cards/delete/{card}', [\App\Http\Controllers\Client\Billing\PaymentsController::class, 'delete'])->name('client.card.delete');
    
    Route::get('/cards/add', [\App\Http\Controllers\Client\Billing\PaymentsController::class, 'add_card'])->name('client.card.add');
    Route::get('/cards/save/callback', [\App\Http\Controllers\Client\Billing\PaymentsController::class, 'save_card_callback'])->name('client.card.callback');
    
    // support
    Route::get('/support/list', [\App\Http\Controllers\Client\SupportController::class, 'list'])->name('client.support.list');
    Route::get('/support/create', [\App\Http\Controllers\Client\SupportController::class, 'create'])->name('client.support.create');
    Route::post('/support/create/action', [\App\Http\Controllers\Client\SupportController::class, 'create_action'])->name('client.support.create.action');
    Route::get('/support/update/{id}', [\App\Http\Controllers\Client\SupportController::class, 'update'])->name('client.support.update');
    Route::post('/support/update/action/{id}', [\App\Http\Controllers\Client\SupportController::class, 'update_action'])->name('client.support.update.action');
    
    // settings
    Route::get('/settings', [\App\Http\Controllers\Shared\SettingsController::class, 'client_data'])->name('client.settings');
    Route::post('/settings/update/profile', [\App\Http\Controllers\Shared\SettingsController::class, 'update_data_action'])->name('client.settings.update.profile');
    Route::post('/settings/update/password', [\App\Http\Controllers\Shared\SettingsController::class, 'update_password_action'])->name('client.settings.update.password');

    // logout
    Route::get('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'client_logout'])->name('client.logout');

});


Route::group(['middleware' => ['auth:agent'] , 'prefix' => 'agent'], function () { 

    // home dashboard
    Route::get('/home', [\App\Http\Controllers\Agent\HomeController::class, 'home'])->name('agent.home');
    
    // contact requests    
    Route::get('/contacts/home', [\App\Http\Controllers\Agent\ContactRequestController::class, 'home'])->name('agent.contacts.home');
    Route::get('/contacts/details/{id}', [\App\Http\Controllers\Agent\ContactRequestController::class, 'details'])->name('agent.contacts.details');
    
    // payments
    Route::get('/payments/list', [\App\Http\Controllers\Agent\Billing\PaymentsController::class, 'payments'])->name('agent.payments');
    Route::get('/payments/invoice/{id}', [\App\Http\Controllers\Agent\Billing\PaymentsController::class, 'invoice'])->name('agent.invoice');
    

    // support
    Route::get('/support/list', [\App\Http\Controllers\Agent\SupportController::class, 'list'])->name('agent.support.list');
    Route::get('/support/create', [\App\Http\Controllers\Agent\SupportController::class, 'create'])->name('agent.support.create');
    Route::post('/support/create/action', [\App\Http\Controllers\Agent\SupportController::class, 'create_action'])->name('agent.support.create.action');
    Route::get('/support/update/{id}', [\App\Http\Controllers\Agent\SupportController::class, 'update'])->name('agent.support.update');
    Route::post('/support/update/action/{id}', [\App\Http\Controllers\Agent\SupportController::class, 'update_action'])->name('agent.support.update.action');


    // settings
    Route::get('/settings', [\App\Http\Controllers\Shared\SettingsController::class, 'client_agent_data'])->name('agent.settings');
    Route::post('/settings/update/profile', [\App\Http\Controllers\Shared\SettingsController::class, 'update_data_action'])->name('agent.settings.update.profile');
    Route::post('/settings/update/password', [\App\Http\Controllers\Shared\SettingsController::class, 'update_password_action'])->name('agent.settings.update.password');


    // logout
    Route::get('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'agent_logout'])->name('agent.logout');

});

// shared urls
Route::group(['middleware' => ['auth:agent,client'] ], function () { 

    // real estate
    Route::get('/properties', [\App\Http\Controllers\Client\PropertyController::class, 'list'])->name('client.property.list');
    Route::get('/properties/create', [\App\Http\Controllers\Client\PropertyController::class, 'create'])->name('client.property.create');
    Route::post('/properties/create/action', [\App\Http\Controllers\Client\PropertyController::class, 'create_action'])->name('client.property.create.action');
    Route::get('/properties/edit/{id}', [\App\Http\Controllers\Client\PropertyController::class, 'edit'])->name('client.property.edit');
    Route::post('/properties/edit/action/{id}', [\App\Http\Controllers\Client\PropertyController::class, 'edit_action'])->name('client.property.edit.action');
    
    Route::delete('/properties/delete/{property}', [\App\Http\Controllers\Client\PropertyController::class, 'delete'])->name('client.property.delete');

    Route::post('/file/upload', [\App\Http\Controllers\Client\PropertyController::class, 'uploadLargeFiles'])->name('client.property.file.upload');    
    
    
});

Route::get('/reset', [\App\Http\Controllers\Subscriptions\PaymentController::class, 'reset'])->name('reset');


 