<?php

use App\Http\Controllers\admin\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index')->name('index');
});
