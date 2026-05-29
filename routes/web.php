<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SignalController;
use App\Http\Controllers\EmergencyResponsesController;
use App\Http\Controllers\InstantEmergencyGroupController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\EmergencyAlertController;


Route::get('/', function () {
    return redirect()->route('admin.admin-login');
});

Route::get('/admin/admin-login', [LoginController::class, 'AdminLogin'])->name('admin.admin-login');
Route::post('/admin/save-login', [LoginController::class, 'SaveLogin'])->name('admin.save-login');
Route::get('/admin/logout', [LoginController::class, 'Logout'])->name('admin.logout');

Route::post('/forgot-password',
    [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}',
    [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password',
    [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');


/// Protected Admin Routes
Route::middleware(['auth'])->group(function () 
{


    Route::get('/admin/admin-dashboard', [DashboardController::class, 'AdminDashboard'])->name('admin.dashboard');

    // Users Module
    Route::get('/admin/users-list', [UserController::class, 'UsersList'])->name('admin.users-list');
    Route::get('/admin/users-details/{id}', [UserController::class, 'UsersDetails'])->name('admin.users-details');

    
    Route::get('/send-emergency', function () {

        return view('send-emergency');

    });

    Route::post('/store-emergency',
        [EmergencyAlertController::class, 'store']);

    Route::get('/admin/emergency-alerts',
        [EmergencyAlertController::class, 'index']);

    Route::post('/update-alert-status/{id}',
        [EmergencyAlertController::class, 'updateStatus']);

    
    // Emergency signal Module
    Route::get('/admin/all-emergency-signals', [SignalController::class, 'AllEmergencySignalsList'])->name('admin.all-emergency-signals');

    // Emergency responses Module
    Route::get('/admin/all-emergency-responses', [EmergencyResponsesController::class, 'AllEmergencyResponsesList'])->name('admin.all-emergency-responses');


    // Routes for Instant emergency groups Module
    Route::get('/admin/instant-emergency-groups', [InstantEmergencyGroupController::class, 'InstantEmergencyGroups'])->name('admin.instant-emergency-groups');

    
    // Routes for Reports Module
    Route::get('/admin/reports-and-logs', [ReportController::class, 'ReportsAndLogsList'])->name('admin.reports-and-logs');

    Route::get(
        '/reports/emergency-alerts',
        [ReportController::class, 'EmergencyAlertsReport']
    )->name('reports.emergency-alerts');

    Route::get(
        '/reports/emergency-responses',
        [ReportController::class, 'EmergencyResponsesReport']
    )->name('reports.emergency-responses');

    // Routes for settings module
    Route::get('/admin/settings', [SettingsController::class, 'settings'])->name('admin.settings');

    Route::post(
        '/admin/profile-update',
        [SettingsController::class, 'profileUpdate']
    )->name('admin.profile.update');

    Route::post(
        '/admin/change-password',
        [SettingsController::class, 'changePassword']
    )->name('admin.change.password');

    
});
