<?php

use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', 'HomeController@index')->name('home');

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Register
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Reset Password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Confirm Password
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Verify Email
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');


Route::get('marketers', [App\Http\Controllers\Manager\HomeController::class, 'marketers'])->name('marketers');
Route::get('marketer/add', [App\Http\Controllers\Manager\HomeController::class, 'addMarketer'])->name('marketer.create');
Route::post('marketer/store', [App\Http\Controllers\Manager\HomeController::class, 'storeMarketer'])->name('marketer.store');
Route::get('/customers', [App\Http\Controllers\Manager\HomeController::class, 'customers'])->name('customers');
Route::get('/daily', [App\Http\Controllers\Manager\HomeController::class, 'daily'])->name('daily');
Route::get('/history', [App\Http\Controllers\Manager\HomeController::class, 'history'])->name('history');
Route::get('/customer/{id}', [App\Http\Controllers\Manager\HomeController::class, 'show'])->name('show');
Route::get('/customer/{id}/history', [App\Http\Controllers\Manager\HomeController::class, 'customerHistory'])->name('customer.history');
Route::get('/password', [App\Http\Controllers\Manager\HomeController::class, 'password'])->name('password');
Route::post('/password',  [App\Http\Controllers\Manager\HomeController::class, 'changePassword'])->name('password.change');


