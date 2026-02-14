<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('/auth/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/profile', [AuthController::class, 'profile']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user-role', [AuthController::class, 'getUserRole']);
    Route::get('/user/profile', [AuthController::class, 'getUserProfile']);
    Route::put('/user/update/profile', [AuthController::class, 'updateProfile']);
    Route::get('/contacts', [AuthController::class, 'userContacts']);
    Route::post('/add/contacts', [AuthController::class, 'userAddContacts']);
    Route::post('/update/contacts/{id}', [AuthController::class, 'updateContact']);
    Route::delete('/delete/contacts/{id}', [AuthController::class, 'deleteContact']);

    // Emergency Group Routes
    Route::post('/signal/trigger', [AuthController::class, 'triggerSignal']);

    Route::post('/user/update-location', [AuthController::class, 'updateLocation']);
    Route::post('/signal/respond', [AuthController::class, 'respondToSignal']);
});
