<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PaymentApprovalsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\TravelPaymentsController;
use App\Http\Controllers\UsersController;
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


Route::prefix('api')->group(function () {
    Route::get('/me', [UsersController::class, 'getAuthUser']);
    //Auth
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::post('/register', [RegisterController::class, 'register']);

    Route::prefix('/payments')->group(function () {
        Route::get('/', [PaymentsController::class, 'getPayments']);
        Route::get('/{id}', [PaymentsController::class, 'getPayment']);
        Route::post('/', [PaymentsController::class, 'store']);
        Route::put('/{id}', [PaymentsController::class, 'update']);
        Route::delete('/{id}', [PaymentsController::class, 'destroy']);
    });
    
    Route::prefix('/travel-payments')->group(function () {
        Route::get('/', [TravelPaymentsController::class, 'getTravelPayments']);
        Route::get('/{id}', [TravelPaymentsController::class, 'getTravelPayment']);
        Route::post('/', [TravelPaymentsController::class, 'store']);
        Route::put('/{id}', [TravelPaymentsController::class, 'update']);
        Route::delete('/{id}', [TravelPaymentsController::class, 'destroy']);
    });
    
    Route::prefix('/payment-approvals')->group(function () {
        Route::get('/approved', [PaymentApprovalsController::class, 'getUserApprovedPayments']);
        Route::get('/', [PaymentApprovalsController::class, 'getApprovals']);
        Route::get('/{id}', [PaymentApprovalsController::class, 'getApproval']);
        Route::post('/', [PaymentApprovalsController::class, 'store']);
        Route::put('/{id}', [PaymentApprovalsController::class, 'update']);
        Route::delete('/{id}', [PaymentApprovalsController::class, 'destroy']);
    });
});
