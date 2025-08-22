<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UpcomingEventController;
use App\Http\Controllers\MediaArticleController;
use App\Http\Controllers\MediaImageController;
use App\Http\Controllers\MediaLinkController;
use App\Http\Controllers\ApplicationController;


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

            
        // store, update, updateStatus, destroy
        // Route::apiResource('events', UpcomingEventController::class)->except(['index', 'show']);
        Route::apiResource('articles', MediaArticleController::class)->except(['index', 'show']);
        Route::apiResource('images', MediaImageController::class)->except(['index', 'show']);


        // --------------------------  Upcoming Event  --------------------------
        Route::post('/events', [UpcomingEventController::class, 'store']);
        Route::patch('/events/{event}', [UpcomingEventController::class, 'update']); 
        Route::get('/events', [UpcomingEventController::class, 'index']);


        // --------------------------  Media Image  --------------------------
        // Route::get('/media/{mediaId}/images', [MediaImageController::class, 'index']);
        // Route::post('/media/{mediaId}/images', [MediaImageController::class, 'store']);
        // Route::delete('/media/images/{id}', [MediaImageController::class, 'destroy']);

        Route::post('/media-images', [MediaImageController::class, 'store']);


        // Route::get('/media/{mediaId}/images', [MediaImageController::class, 'index']);
        // Route::post('/media/{mediaId}/images', [MediaImageController::class, 'store']); // upload multiple
        // Route::delete('/media/image/{id}', [MediaImageController::class, 'destroy']); // soft delete
        // Route::post('/media/image/{id}/restore', [MediaImageController::class, 'restore']);
        // Route::delete('/media/image/{id}/force-delete', [MediaImageController::class, 'forceDelete']);


        // --------------------------  Application  --------------------------
        Route::apiResource('applications', ApplicationController::class)->except(['store']);
        Route::get('/applications/company/{company}', [ApplicationController::class, 'getByCompany']);
        Route::get('/applications/department/{department}', [ApplicationController::class, 'getByDepartment']);
        Route::get('/positions', [ApplicationController::class, 'getPositions']);
        Route::patch('/applications/{id}/status', [ApplicationController::class, 'updateStatus']);

});

    Route::apiResource('events', UpcomingEventController::class)->only(['index', 'show']);
    Route::apiResource('articles', MediaArticleController::class)->only(['index', 'show']);
    Route::apiResource('images', MediaImageController::class)->only(['index', 'show']);
    Route::apiResource('links', MediaLinkController::class)->only(['index', 'show']);


    // --------------------------  Application  --------------------------
    Route::post('/applications', [ApplicationController::class, 'store']);





