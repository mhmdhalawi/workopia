<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
// Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

Route::resource('jobs', JobController::class)->only(['index', 'show']);
