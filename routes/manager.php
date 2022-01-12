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

Route::get('users', [App\Http\Controllers\Manager\HomeController::class, 'users'])->name('users');
Route::get('user/{id}', [App\Http\Controllers\Manager\HomeController::class, 'userDetail'])->name('user');
Route::post('user/block', [App\Http\Controllers\Manager\HomeController::class, 'blockUser'])->name('user.block');
Route::post('user/delete', [App\Http\Controllers\Manager\HomeController::class, 'deleteUser'])->name('user.delete');
Route::get('user/{id}/transactions', [App\Http\Controllers\Manager\HomeController::class, 'userTransactions'])->name('user.transactions');
Route::get('/users/{terms}/search', [App\Http\Controllers\Manager\HomeController::class, 'searchUsers'])->name('users.search');
Route::get('transactions', [App\Http\Controllers\Manager\HomeController::class, 'transactions'])->name('transactions');
Route::get('transaction/{id}', [App\Http\Controllers\Manager\HomeController::class, 'transaction'])->name('transaction');
Route::get('/transactions/{terms}/search', [App\Http\Controllers\Manager\HomeController::class, 'searchTransactions'])->name('transactions.search');
Route::post('transaction/approve', [App\Http\Controllers\Manager\HomeController::class, 'approveTransaction'])->name('transaction.approve');
Route::post('transaction/reject', [App\Http\Controllers\Manager\HomeController::class, 'rejectTransaction'])->name('transaction.reject');
Route::get('transaction/sell/pending', [App\Http\Controllers\Manager\HomeController::class, 'pendingSellTransactions'])->name('pending_sell_transactions');
Route::get('transaction/buy/pending', [App\Http\Controllers\Manager\HomeController::class, 'pendingBuyTransactions'])->name('pending_buy_transactions');
Route::get('identity/verify', [App\Http\Controllers\Manager\HomeController::class, 'identityVerification'])->name('kyc_verification');
Route::post('identity/confirm', [App\Http\Controllers\Manager\HomeController::class, 'markUserAsVerified'])->name('confirm');
Route::get('notifications', [App\Http\Controllers\Manager\HomeController::class, 'notifications'])->name('notifications');
Route::get('support', [App\Http\Controllers\Manager\HomeController::class, 'tickets'])->name('support');
Route::post('/ticket/comment', [App\Http\Controllers\Manager\HomeController::class, 'comment'])->name('ticket.comment');
Route::get('/ticket/{id}', [App\Http\Controllers\Manager\HomeController::class, 'ticket'])->name('ticket.show');
Route::get('/categories', [App\Http\Controllers\Manager\HomeController::class, 'categories'])->name('categories');
