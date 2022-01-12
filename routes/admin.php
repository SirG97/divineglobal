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
Route::get('transactions', [App\Http\Controllers\Admin\HomeController::class, 'transactions'])->name('transactions');
Route::get('transaction/{id}', [App\Http\Controllers\Admin\HomeController::class, 'transaction'])->name('transaction');
Route::get('/transactions/{terms}/search', [App\Http\Controllers\Admin\HomeController::class, 'searchTransactions'])->name('transactions.search');
Route::post('transaction/approve', [App\Http\Controllers\Admin\HomeController::class, 'approveTransaction'])->name('transaction.approve');
Route::post('transaction/reject', [App\Http\Controllers\Admin\HomeController::class, 'rejectTransaction'])->name('transaction.reject');
Route::get('transaction/sell/pending', [App\Http\Controllers\Admin\HomeController::class, 'pendingSellTransactions'])->name('pending_sell_transactions');
Route::get('transaction/buy/pending', [App\Http\Controllers\Admin\HomeController::class, 'pendingBuyTransactions'])->name('pending_buy_transactions');
Route::get('identity/verify', [App\Http\Controllers\Admin\HomeController::class, 'identityVerification'])->name('kyc_verification');
Route::post('identity/confirm', [App\Http\Controllers\Admin\HomeController::class, 'markUserAsVerified'])->name('confirm');
Route::get('notifications', [App\Http\Controllers\Admin\HomeController::class, 'notifications'])->name('notifications');
Route::get('support', [App\Http\Controllers\Admin\HomeController::class, 'tickets'])->name('support');
Route::post('/ticket/comment', [App\Http\Controllers\Admin\HomeController::class, 'comment'])->name('ticket.comment');
Route::get('/ticket/{id}', [App\Http\Controllers\Admin\HomeController::class, 'ticket'])->name('ticket.show');
Route::get('/categories', [App\Http\Controllers\Admin\HomeController::class, 'categories'])->name('categories');


