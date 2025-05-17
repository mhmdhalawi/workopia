<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;



// Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
Route::resource('jobs', JobController::class);
