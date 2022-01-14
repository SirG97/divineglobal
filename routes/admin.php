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

Route::get('branches', [App\Http\Controllers\Admin\HomeController::class, 'branches'])->name('branches');
Route::post('branches', [App\Http\Controllers\Admin\HomeController::class, 'addBranch'])->name('branch.store');

Route::get('managers', [App\Http\Controllers\Admin\HomeController::class, 'managers'])->name('managers');
Route::get('manager/add', [App\Http\Controllers\Admin\HomeController::class, 'addManager'])->name('manager.create');
Route::post('manager/store', [App\Http\Controllers\Admin\HomeController::class, 'storeManager'])->name('manager.store');

Route::get('users', [App\Http\Controllers\Admin\HomeController::class, 'users'])->name('users');
Route::get('user/{id}', [App\Http\Controllers\Admin\HomeController::class, 'userDetail'])->name('user');
Route::get('user/{id}/transactions', [App\Http\Controllers\Admin\HomeController::class, 'userTransactions'])->name('user.transactions');
Route::get('/users/{terms}/search', [App\Http\Controllers\Admin\HomeController::class, 'searchUsers'])->name('users.search');
Route::get('marketers', [App\Http\Controllers\Admin\HomeController::class, 'marketers'])->name('marketers');
Route::get('/customers', [App\Http\Controllers\Admin\HomeController::class, 'customers'])->name('customers');
Route::get('/daily', [App\Http\Controllers\Admin\HomeController::class, 'daily'])->name('daily');
Route::get('/history', [App\Http\Controllers\Admin\HomeController::class, 'history'])->name('history');
Route::get('/customer/{id}', [App\Http\Controllers\Admin\HomeController::class, 'show'])->name('show');
Route::get('/customer/{id}/history', [App\Http\Controllers\Admin\HomeController::class, 'customerHistory'])->name('customer.history');
Route::get('/password', [App\Http\Controllers\Admin\HomeController::class, 'password'])->name('password');
Route::post('/password',  [App\Http\Controllers\Admin\HomeController::class, 'changePassword'])->name('password.change');

