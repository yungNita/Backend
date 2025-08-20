<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;

use App\Http\Controllers\ProjectProposalController;
use App\Http\Controllers\VisitRequestController;
use App\Http\Controllers\ContactMessageController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    // -------------------- Admin Only --------------------
    
        // Manage Users (CRUD admins + staff)
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::patch('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        // Admin dashboard
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard']);
    

    // -------------------- Staff Only --------------------
        Route::get('/staff/dashboard', [StaffDashboardController::class, 'dashboard']);

    // -------------------- Shared (Admin + Staff) --------------------
        Route::get('/me', function (Request $request) {
            return $request->user();
        });


    // -------------------- project - visit - contact --------------------
        Route::resource('project-proposals', ProjectProposalController::class);
        Route::get('project-proposals/{project_id}/restore', [ProjectProposalController::class, 'restore'])->name('project-proposals.restore');
        Route::resource('visit-requests', VisitRequestController::class);
        Route::get('visit-requests/{visit_id}/restore', [VisitRequestController::class, 'restore'])->name('visit-requests.restore');
        Route::resource('contact-messages', ContactMessageController::class);
        Route::get('contact-messages/{message_id}/restore', [ContactMessageController::class, 'restore'])->name('contact-messages.restore');

        
});

