<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;

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
        Route::prefix('banner')->group(function () {
            Route::controller(BannerController::class)->group(function () {
                Route::get('/', 'index')->name('admin.banner');
                Route::get('create', 'create_banner')->name('admin.banner.create');
                Route::post('insert', 'insert_banner')->name('admin.banner.insert');
                Route::get('edit/{id}', 'edit_banner')->name('admin.banner.edit');
                Route::get('delete', 'delete_banner')->name('admin.banner.delete');
            });
        });
    });
});
