<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile
    Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('index');

    Route::get('/customer/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('create');
    Route::post('/customer/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('store');
    Route::get('/customer/edit', [App\Http\Controllers\CustomerController::class, 'edit'])->name('edit');
    Route::get('/customer/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('show');
    Route::post('/customer/update', [App\Http\Controllers\CustomerController::class, 'update'])->name('update');
    Route::get('/savings', [App\Http\Controllers\CustomerController::class, 'savings'])->name('savings');
    Route::get('/mark', [App\Http\Controllers\CustomerController::class, 'mark'])->name('mark');
    Route::get('/withdrawals', [App\Http\Controllers\CustomerController::class, 'withdrawals'])->name('withdrawals');
    Route::get('/withdraw', [App\Http\Controllers\CustomerController::class, 'withdraw'])->name('withdraw');
    Route::get('/password', [App\Http\Controllers\CustomerController::class, 'password'])->name('password');

    Route::post('/account/resolve', [App\Http\Controllers\CustomerController::class, 'resolveAccountNumber'])->name('account.resolve');

    Route::get('/tickets', [App\Http\Controllers\HomeController::class, 'tickets'])->name('tickets');
    Route::get('/ticket/new', [App\Http\Controllers\HomeController::class, 'newTicket'])->name('ticket.create');
    Route::post('/ticket/new', [App\Http\Controllers\HomeController::class, 'createTicket'])->name('ticket.store');


    Route::post('/ticket/comment', [App\Http\Controllers\HomeController::class, 'comment'])->name('ticket.comment');
    Route::get('/ticket/{id}', [App\Http\Controllers\HomeController::class, 'ticket'])->name('ticket.show');

    Route::get('/referrals', [App\Http\Controllers\HomeController::class, 'referrals'])->name('referrals');
    Route::get('/reviews', [App\Http\Controllers\HomeController::class, 'reviews'])->name('reviews');
    Route::post('/review/save', [App\Http\Controllers\HomeController::class, 'saveReview'])->name('review.save');
    Route::get('/transactions', [App\Http\Controllers\HomeController::class, 'transactions'])->name('transactions');
    Route::get('transaction/{id}', [App\Http\Controllers\HomeController::class, 'transaction'])->name('transaction');
    Route::post('transaction/reupload', [App\Http\Controllers\HomeController::class, 'reUploadProof'])->name('transaction.reupload');
    Route::get('/notifications', [App\Http\Controllers\HomeController::class, 'notifications'])->name('notifications');
    Route::get('/success', [App\Http\Controllers\HomeController::class, 'success'])->name('success');
    Route::get('/error', [App\Http\Controllers\HomeController::class, 'error'])->name('error');


