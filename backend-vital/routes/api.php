<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UpcomingEventController;
// use App\Http\Controllers\MediaArticleController;
use App\Http\Controllers\MediaImageController;
// use App\Http\Controllers\MediaLinkController;
use App\Http\Controllers\ApplicationController;


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
        Route::post('post-jobs/{job_id}/schedule-post', [PostJobController::class, 'schedule'])->name('post-jobs.schedule');
        Route::get('post-jobs/{job_id}/close', [PostJobController::class, 'close'])->name('post-jobs.close');

     // --------------------------  Media  --------------------------
        Route::get('/media', [MediaController::class, 'index']);
        Route::get('/media/archived', [MediaController::class, 'archived']);
        Route::get('/media/{id}', [MediaController::class, 'show']); // Get by ID
        Route::get('/media/category/{category}', [MediaController::class, 'getByCategory']); // Get by category
        Route::post('/media', [MediaController::class, 'store']);
        Route::patch('/media/{id}', [MediaController::class, 'update']);
        Route::patch('/media/{id}/status', [MediaController::class, 'updateStatus']);
        Route::delete('/media/{id}', [MediaController::class, 'destroy']);
        Route::post('/media/{id}/restore', [MediaController::class, 'restore']);
        Route::delete('/media/{id}/force-delete', [MediaController::class, 'forceDelete']);

            

        // --------------------------  Upcoming Event  --------------------------
        Route::post('/events', [UpcomingEventController::class, 'store']);
        Route::patch('/events/{event}', [UpcomingEventController::class, 'update']); 
        Route::get('/events', [UpcomingEventController::class, 'index']);


        // --------------------------  Media Image  --------------------------
        Route::post('/images', [MediaImageController::class, 'store']);
        // Route::patch('/media-images/{id}', [MediaImageController::class, 'update']);
        // Route::delete('/media-images/{id}', [MediaImageController::class, 'destroy']);
        // Route::post('/media-images/{id}/restore', [MediaImageController::class, 'restore']);
        // Route::delete('/media-images/{id}/force-delete', [MediaImageController::class, 'forceDelete']);
        // Route::post('/media-images/{id}/set-cover', [MediaImageController::class, 'setCover']);


        // --------------------------  Application  --------------------------
        Route::apiResource('applications', ApplicationController::class)->except(['store']);
        Route::get('/applications/company/{company}', [ApplicationController::class, 'getByCompany']);
        Route::get('/applications/department/{department}', [ApplicationController::class, 'getByDepartment']);
        Route::get('/positions', [ApplicationController::class, 'getPositions']);
        Route::patch('/applications/{id}/status', [ApplicationController::class, 'updateStatus']);

});

    // Route::apiResource('events', UpcomingEventController::class)->only(['index', 'show']);
    // Route::apiResource('articles', MediaArticleController::class)->only(['index', 'show']);
    // Route::apiResource('images', MediaImageController::class)->only(['index', 'show']);
    // Route::apiResource('links', MediaLinkController::class)->only(['index', 'show']);


    // --------------------------  Application  --------------------------
    Route::post('/applications', [ApplicationController::class, 'store']);


    // Public Routes for normal users
    Route::post('project-proposals', [ProjectProposalController::class, 'store']);
    Route::post('visit-requests', [VisitRequestController::class, 'store']);
    Route::post('contact-messages', [ContactMessageController::class, 'store']);
    Route::get('post-jobs/user-display', [PostJobController::class, 'display'])->name('post-jobs.display');



Route::post('/test-media', function() {
    return response()->json(['ok' => true]);
});



