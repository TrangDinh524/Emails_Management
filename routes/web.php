<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AdminController;

Route::get('/', [EmailController::class, 'create'])->name('emails.create');
Route::post('/store', [EmailController::class, 'store'])->name('emails.store');
Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');
Route::get('/emails/{id}', [EmailController::class, 'show'])->name('emails.show');
Route::delete('/emails/{id}', [EmailController::class, 'destroy'])->name('emails.destroy');

//Email Sending routes
Route::get('/compose-emails', [EmailController::class, 'showComposeForm'])->name('emails.compose');
Route::post('/send-email-by-queue', [EmailController::class, 'sendBulkEmailByQueue'])->name('emails.send-email');
Route::post('/send-email-immediate', [EmailController::class, 'sendBulkEmailImmediate'])->name('emails.send-email-immediate');

// Queue monitoring routes
Route::get('/queue-status', [EmailController::class, 'queueStatus'])->name('emails.queue-status');

// Admin route for generating daily report
Route::get('/admin/generate-daily-report', [AdminController::class, 'generateDailyReport'])->name('admin.generate-daily-report');
