<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    // Public Routes
    Route::post('register', [AuthController::class, 'register']);

    Route::post('login', [AuthController::class, 'login']);

    Route::post('send-otp', [AuthController::class, 'sendOtp']);

    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);

        // Protected Routes
        Route::middleware('auth:sanctum')->group(function () {

            Route::get('profile', [AuthController::class, 'profile']);

            Route::post('update-profile', [AuthController::class, 'updateProfile']);

            Route::post('logout', [AuthController::class, 'logout']);

            Route::get('user-role', [AuthController::class, 'getUserRole']);

            Route::get('contacts', [AuthController::class, 'userContacts']);

            Route::post('add/contacts', [AuthController::class, 'userAddContacts']);

            Route::post('update/contacts/{id}', [AuthController::class, 'updateContact']);

            Route::delete('delete/contacts/{id}', [AuthController::class, 'deleteContact']);

            // Emergency Routes
            Route::post('signal/trigger', [AuthController::class, 'triggerSignal']);

            Route::post('user/update-location', [AuthController::class, 'updateLocation']);

            Route::post('signal/respond', [AuthController::class, 'respondToSignal']);

            // Community Routes
            Route::post('community/create', [AuthController::class, 'createCommunity']);

            Route::post('community/add-contacts', [AuthController::class, 'addContactsToCommunity']);

        });

});