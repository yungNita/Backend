<?php

use App\Http\Controllers\ProjectProposalController;
use App\Http\Controllers\VisitRequestController;
use App\Http\Controllers\ContactMessageController;
use Illuminate\Support\Facades\Route;

Route::resource('project-proposals', ProjectProposalController::class);
Route::resource('visit-requests', VisitRequestController::class);
Route::resource('contact-messages', ContactMessageController::class);
