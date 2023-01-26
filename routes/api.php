<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TravelPaymentController;
use App\Http\Controllers\UserController;
use App\Models\User;
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
    /**
     * API Resource routes for payments and travel-payments
     *
     */
    Route::apiResources([
        'payments' => PaymentController::class,
        'travel-payments' => TravelPaymentController::class,
    ]);

    /**
     * API routes for approvin and disapproving payments and travel-payments
     * You will need APPROVER type privilege for those actions
     */
    Route::middleware(['hasPrivilege:' . User::APPROVER])->group(function () {
        Route::controller(PaymentController::class)->group(function () {
            Route::post('/payments/{payment}/approve', 'approve');
            Route::post('/payments/{payment}/disapprove', 'disapprove');
        });

        Route::controller(TravelPaymentController::class)->group(function () {
            Route::post('/travel-payments/{travelPayment}/approve', 'approve');
            Route::post('/travel-payments/{travelPayment}/disapprove', 'disapprove');
        });
    });

    /**
     * User API routes
     * Maybe we could consider some ADMIN type for set-type and delete actions
     */
    Route::controller(UserController::class)->group(function () {
        Route::post('/users/{user}/set-type', 'setType');
        Route::get('/users/report/{user?}', 'report');
        Route::delete('/users/{user}/delete', 'destroy');
    });

    /**
     * Logout route
     */
    Route::post('/logout', [AuthController::class, 'logout']);
});

/**
 * Auth API routes for user login and registration
 */
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login')->name('login');
});
