<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    require base_path('routes/admin.php');
});

Route::prefix('market')->group(function () {
    require base_path('routes/market.php');
});
