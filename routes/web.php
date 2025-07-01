<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'index')->name('admin-login');
        Route::post('/', 'login')->name('login');
    });
    Route::controller(HomeController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('admin-dashboard');
    });
});
