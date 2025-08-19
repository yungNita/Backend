<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    // -------------------- Admin Only --------------------
    // Route::middleware('role:admin')->group(function () {
        // Manage Users (CRUD admins + staff)
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::patch('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        // Admin dashboard
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard']);
    

    // -------------------- Staff Only --------------------
    // Route::middleware('role:staff')->group(function () {
        Route::get('/staff/dashboard', [StaffDashboardController::class, 'dashboard']);
    // });

    // -------------------- Shared (Admin + Staff) --------------------
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
});





