<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; 
use App\Models\Banner;
use App\Models\Category;
use App\Helpers\ResponseBuilder;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function getBanner()
    {
        $banners = Banner::select('id','url','image')->get();
        return ResponseBuilder::success($banners, 'Banners fetched successfully', 201);
    }

    public function categories()
    {
        $categories = Category::select('id', 'name', 'slug', 'parent_id', 'image')->get();
        return response()->json(['categories' => $categories]);
    }

    public function top_categories()
    {
        $categories = Category::select('id', 'name', 'slug', 'image')->where('is_featured',1)->get();
        return ResponseBuilder::success($categories, 'Categories fetched successfully', 201);
    }

}
