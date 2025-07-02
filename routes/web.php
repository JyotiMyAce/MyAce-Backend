<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;

// Route::prefix('admin')->group(function () {
//     Route::middleware(['guest:admin', PreventBackHistory::class])->group(function () {
//         Route::controller(AuthController::class)->group(function () {
//             Route::get('/', 'index')->name('admin-login'); // login page
//             Route::post('/login', 'login')->name('admin.login'); // ⬅️ USE a unique name here
//         });
//     });

//     Route::middleware(['auth:admin', PreventBackHistory::class])->group(function () {
//         Route::controller(HomeController::class)->group(function () {
//             Route::get('/dashboard', 'index')->name('admin-dashboard');
//         });
//     });
// });

Route::prefix('admin')->group(function () {

    // Guest routes (unauthenticated admin)
    Route::middleware(['guest:admin', PreventBackHistory::class])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('/', 'index')->name('admin.login.form'); 
            Route::post('/login', 'login')->name('admin.login'); 
        });
    });

    // Authenticated admin routes
    Route::middleware(['auth:admin', PreventBackHistory::class])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('/logout', 'logout')->name('admin.logout');
        });
        Route::controller(HomeController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('admin.dashboard'); 
        });
    });
});
