<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/save/contact', [\App\Http\Controllers\Client\ContactRequestController::class, 'save_contact'])->name('save.contact');