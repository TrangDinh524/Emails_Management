<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

Route::get('/', [EmailController::class, 'create'])->name('emails.create');
Route::post('/store', [EmailController::class, 'store'])->name('emails.store');
Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');

Route::get('/emails/{id}', [EmailController::class, 'show'])->name('emails.show');
Route::delete('/emails/{id}', [EmailController::class, 'destroy'])->name('emails.destroy');
