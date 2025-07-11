<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/getuser-detail/{id}', [AuthController::class, 'getuser'])
->where('id', '[0-9a-fA-F\-]{36}');
Route::post('/forgot-password', [AuthController::class, 'forgotPasswordByPhone']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);


Route::get('/banners', [HomeController::class, 'getBanner']);
Route::get('/categories', [HomeController::class, 'categories']); 
Route::get('/top-categories', [HomeController::class, 'top_categories']); 
Route::get('/benefitsslider-list', [HomeController::class, 'getslider']); 
Route::get('/videos-list', [HomeController::class, 'getVideoList']); 
Route::get('/all-categories', [HomeController::class, 'getAllCategories']); 
Route::get('/banner-basedon-category', [HomeController::class, 'getCategoriesBanners']); 
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
