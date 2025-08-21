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
use App\Http\Controllers\PostJobController;

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
        // Project Proposals
        Route::get('project-proposals', [ProjectProposalController::class, 'index']);
        Route::get('project-proposals/{id}', [ProjectProposalController::class, 'show']);
        Route::delete('project-proposals/{id}', [ProjectProposalController::class, 'destroy']);
        Route::patch('project-proposals/{id}', [ProjectProposalController::class, 'update']);
        Route::get('project-proposals/{project_id}/restore', [ProjectProposalController::class, 'restore'])->name('project-proposals.restore');

        // Visit Requests
        Route::get('visit-requests', [VisitRequestController::class, 'index']);
        Route::get('visit-requests/{id}', [VisitRequestController::class, 'show']);
        Route::delete('visit-requests/{id}', [VisitRequestController::class, 'destroy']);
        Route::patch('visit-requests/{id}', [VisitRequestController::class, 'update']);
        Route::get('visit-requests/{visit_id}/restore', [VisitRequestController::class, 'restore'])->name('visit-requests.restore');

        // Contact Messages
        Route::get('contact-messages', [ContactMessageController::class, 'index']);
        Route::get('contact-messages/{message_id}', [ContactMessageController::class, 'show']);
        Route::delete('contact-messages/{message_id}', [ContactMessageController::class, 'destroy']);
        Route::get('contact-messages/{message_id}/restore', [ContactMessageController::class, 'restore'])->name('contact-messages.restore');

        // Post Jobs
        Route::resource('post-jobs', PostJobController::class);
        Route::get('post-jobs/{job_id}/restore', [PostJobController::class, 'restore'])->name('post-jobs.restore');
        Route::get('post-jobs/{job_id}/publish', [PostJobController::class, 'publish'])->name('post-jobs.publish');
        Route::post('post-jobs/{job_id}/schedule', [PostJobController::class, 'schedule'])->name('post-jobs.schedule');
        Route::get('post-jobs/{job_id}/close', [PostJobController::class, 'close'])->name('post-jobs.close');
});

// Public Routes for normal users
Route::post('project-proposals', [ProjectProposalController::class, 'store']);
Route::post('visit-requests', [VisitRequestController::class, 'store']);
Route::post('contact-messages', [ContactMessageController::class, 'store']);


