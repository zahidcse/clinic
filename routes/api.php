<?php

use App\Http\Controllers\Api\Appointment\AppointmentController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Invoice\InvoiceController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    // Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
});

Route::group([
    'middleware' => 'auth:api',
], function () {
    // Profile
    Route::get('/user-data', [UserController::class, 'userData'])->name('user.data');
    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update.profile');
    // Route::post('/update-user-avatar', [UserController::class, 'updateAvatar'])->name('update.avatar');

    // Total count
    Route::post('/user-analytics', [UserController::class, 'getAnalytics'])->name('user.analytics');
    // General note
    Route::get('/general-notes', [UserController::class, 'generalNotes'])->name('general.notes');

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'appointments'])->name('appointments');
    Route::get('/appointment-notes', [AppointmentController::class, 'appointmentNotes'])->name('appointment.notes');

    // Invoice
    Route::get('/invoices', [InvoiceController::class, 'invoices'])->name('invoices');
    Route::get('/invoice/details/{id}', [InvoiceController::class, 'invoiceDetails'])->name('invoice.details');
});

Route::post('/test', function () {
    return response()->json(['message' => 'Hello World!']);
});

Route::post('/update-user-avatar', [UserController::class, 'updateAvatar'])->name('update.avatar');
