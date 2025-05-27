<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('jobs', JobController::class);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::patch('bookmarks/{jobId}', [BookmarkController::class, 'toggleBookmark'])->name('bookmarks.toggle');
    Route::apiResource('bookmarks', BookmarkController::class)->only(['index', 'show']);
});
