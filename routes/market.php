<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
// Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');


Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::resource('jobs', JobController::class)->only(['index', 'show'])->middleware('auth:sanctum');;
