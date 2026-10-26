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

    // contact
        Route::get('contacts', [AuthController::class, 'userContacts']);

        Route::post('add/contacts', [AuthController::class, 'userAddContacts']);

        Route::put('contacts/{id}', [AuthController::class, 'updateContact']);

            Route::delete('delete/contacts/{id}', [AuthController::class, 'deleteContact']);

        // Protected Routes
        Route::middleware('auth:sanctum')->group(function () {

            Route::get('profile', [AuthController::class, 'profile']);

            Route::post('update-profile', [AuthController::class, 'updateProfile']);

            Route::post('logout', [AuthController::class, 'logout']);

            Route::get('user-role', [AuthController::class, 'getUserRole']);

            // Emergency Routes
            Route::post('signal/trigger', [AuthController::class, 'triggerSignal']);

            Route::get('signal/nearby', [AuthController::class, 'nearbySignals']);

            Route::post('user/update-location', [AuthController::class, 'updateLocation']);

            Route::post('signal/respond', [AuthController::class, 'respondToSignal']);

            Route::post(
                'signal/update-response-status',
                [AuthController::class, 'updateResponseStatus']
            );

            Route::get(
                'signal/status/{signalId}',
                [AuthController::class, 'getSignalStatus']
            );

            // Community Routes
            Route::post('community/create', [AuthController::class, 'createCommunity']);

            Route::post('community/add-contacts', [AuthController::class, 'addContactsToCommunity']);

        });

});