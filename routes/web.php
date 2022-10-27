<?php

use App\Http\Controllers\PaymentsController;
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

Route::prefix('api')->group(function () {
    Route::prefix('/payments')->group(function () {
        Route::get('/', [PaymentsController::class, 'getPayments']);
        Route::get('/{id}', [PaymentsController::class, 'getPayment']);
        Route::post('/', [PaymentsController::class, 'store']);
        Route::put('/{id}', [PaymentsController::class, 'update']);
        Route::delete('/{id}', [PaymentsController::class, 'delete']);
    });
});
