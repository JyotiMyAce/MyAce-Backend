<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; 
use App\Models\Banner;
use App\Helpers\ResponseBuilder;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function getBanner()
    {
        $banners = Banner::all();
        $responseData = [
            'data' => $banners
        ];
        return ResponseBuilder::success($responseData, 'Banners fetched successfully', 201);
    }

    public function categories()
    {
        $categories = Category::select('id', 'name', 'slug', 'parent_id', 'image')->get();
        return response()->json(['categories' => $categories]);
    }

    public function top_categories()
    {
        $categories = Category::select('id', 'name', 'slug', 'parent_id', 'image')->where('is_featured',1)->get();
        return response()->json(['categories' => $categories]);
    }

}
