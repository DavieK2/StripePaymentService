<?php

use App\Http\Controllers\CashPaymentController;
use App\Http\Controllers\PaymentCancelledController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentMethodToggleActiveStatusController;
use App\Http\Controllers\PaymentSuccessfulController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPaymentMethodController;
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

Route::get('/', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{userId}', [UserController::class, 'show'])->name('user.show');
Route::delete('/user/{userId}/delete', [UserController::class, 'destroy'])->name('user.destroy');
Route::post('/user-payment-method/{userId}/{paymentMethodId}', [UserPaymentMethodController::class, 'create'])->name('user.create.payment_method');
Route::post('/user-payment-method/{userId}/{paymentMethodId}/update', [UserPaymentMethodController::class, 'update'])->name('user.update.payment_method');
Route::post('/user-payment-method/{userId}/{paymentMethodId}/delete', [UserPaymentMethodController::class, 'destroy'])->name('user.delete.payment_method');

Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('payment.index');
Route::get('/payment-method/create', [PaymentMethodController::class, 'create'])->name('payment.create');
Route::post('/payment-method/create', [PaymentMethodController::class, 'store'])->name('payment.store');
Route::get('/payment-method/{paymentMethodId}/edit', [PaymentMethodController::class, 'edit'])->name('payment.edit');
Route::patch('/payment-method/{paymentMethodId}/update', [PaymentMethodController::class, 'update'])->name('payment.update');
Route::delete('/payment-method/{paymentMethodId}/delete', [PaymentMethodController::class, 'destroy'])->name('payment.destroy');
Route::patch('/payment-method/{paymentMethodId}/toggle', [PaymentMethodToggleActiveStatusController::class, 'update'])->name('payment.toggle');

Route::get('/checkout/cash/', [CashPaymentController::class, 'index'])->name('payment.checkout.cash');

Route::post('/checkout/{userId}', [PaymentController::class, 'create'])->name('payment.checkout');
Route::get('/payment-successful', [PaymentSuccessfulController::class, 'index'])->name('payment.succesful');
Route::get('/payment-cancel', [PaymentCancelledController::class, 'index'])->name('payment.cancel');

Route::get('/refund/{paymentId}', [RefundController::class, 'store'])->name('refund.store');
