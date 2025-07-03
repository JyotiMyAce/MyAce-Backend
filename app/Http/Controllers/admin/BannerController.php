<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request){
        return view('banner.index');
    }
}
