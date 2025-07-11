<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/getuser-detail/{id}', [AuthController::class, 'getuser'])
    ->where('id', '[0-9a-fA-F\-]{36}');
Route::post('/forgot-password', [AuthController::class, 'forgotPasswordByPhone']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);


Route::controller(HomeController::class)->group(function () {
    Route::post('/banners', 'getBanner')->name('getBanner');
});
