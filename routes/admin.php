<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;



// Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');

Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::resource('jobs', JobController::class)->middleware('auth:sanctum');
