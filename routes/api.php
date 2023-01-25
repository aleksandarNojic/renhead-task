<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TravelPaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'payments' => PaymentController::class,
        'travel-payments' => TravelPaymentController::class,
    ]);

    Route::controller(PaymentController::class)->group(function () {
        Route::post('/payments/{payment}/approve', 'approve');
        Route::post('/payments/{payment}/disapprove', 'disapprove');
    });

    Route::controller(TravelPaymentController::class)->group(function () {
        Route::post('/travel-payments/{travelPayment}/approve', 'approve');
        Route::post('/travel-payments/{travelPayment}/disapprove', 'disapprove');
    });

    Route::controller(UserController::class)->group(function () {
        Route::post('/users/{user}/set-type', 'setType');
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login')->name('login');
});
