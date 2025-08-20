<?php

use App\Http\Controllers\ProjectProposalController;
use App\Http\Controllers\VisitRequestController;
use App\Http\Controllers\ContactMessageController;
use Illuminate\Support\Facades\Route;

Route::resource('project-proposals', ProjectProposalController::class);
Route::get('project-proposals/{project_id}/restore', [ProjectProposalController::class, 'restore'])->name('project-proposals.restore');
Route::resource('visit-requests', VisitRequestController::class);
Route::get('visit-requests/{visit_id}/restore', [VisitRequestController::class, 'restore'])->name('visit-requests.restore');
Route::resource('contact-messages', ContactMessageController::class);
Route::get('contact-messages/{message_id}/restore', [ContactMessageController::class, 'restore'])->name('contact-messages.restore');
