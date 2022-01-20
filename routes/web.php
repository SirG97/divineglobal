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
    return view('auth.login');
});

Auth::routes();


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Profile
    Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('index');

    Route::get('/customer/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('create');
    Route::post('/customer/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('store');
    Route::post('/customer/edit', [App\Http\Controllers\CustomerController::class, 'edit'])->name('edit');
    Route::get('/customer/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('show');
    Route::get('/customers/{id}/search', [App\Http\Controllers\CustomerController::class, 'search'])->name('search');
    Route::get('/customer/{id}/history', [App\Http\Controllers\CustomerController::class, 'customerHistory'])->name('customer.history');
    Route::post('/customer/update', [App\Http\Controllers\CustomerController::class, 'update'])->name('update');
    Route::get('/save/{id}', [App\Http\Controllers\CustomerController::class, 'save'])->name('save');
    Route::post('/mark', [App\Http\Controllers\CustomerController::class, 'mark'])->name('mark');
    Route::get('/daily', [App\Http\Controllers\CustomerController::class, 'daily'])->name('daily');
    Route::get('/history', [App\Http\Controllers\CustomerController::class, 'history'])->name('history');
    Route::get('/withdraw/{id}', [App\Http\Controllers\CustomerController::class, 'withdraw'])->name('withdraw');
    Route::post('/withdraw', [App\Http\Controllers\CustomerController::class, 'storeWithdraw'])->name('withdraw.store');
    Route::get('/password', [App\Http\Controllers\HomeController::class, 'password'])->name('password');
    Route::post('/password',  [App\Http\Controllers\HomeController::class, 'changePassword'])->name('password.change');
    Route::post('/account/resolve', [App\Http\Controllers\CustomerController::class, 'resolveAccountNumber'])->name('account.resolve');
    Route::get('/transactions', [App\Http\Controllers\HomeController::class, 'transactions'])->name('transactions');
    Route::get('transaction/{id}', [App\Http\Controllers\HomeController::class, 'transaction'])->name('transaction');



