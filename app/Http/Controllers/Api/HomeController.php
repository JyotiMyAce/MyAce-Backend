<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; 
use App\Models\Banner;
use App\Models\Category;
use App\Models\HomeVideo;
use App\Helpers\ResponseBuilder;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function getBanner()
    {
        $banners = Banner::select('id','redirect_url','banner_img')
        ->where('type','banner')
        ->get()
        ->map(function ($banner) {
            return [
                'id'         => $banner->id,
                'url'        => $banner->redirect_url,
                'image' => url('storage/' . $banner->banner_img),
            ];
        });
        return ResponseBuilder::success($banners, 'Banners fetched successfully', 201);
    }


    public function categories()
    {
        $categories = Category::select('id', 'name', 'slug', 'parent_id', 'image')->get();
        return response()->json(['categories' => $categories]);
    }

    public function top_categories()
    {
        $categories = Category::select('id', 'name', 'slug', 'image')->where('is_featured',1)->where('feature_in_banner',0)->get();
        return ResponseBuilder::success($categories, 'Categories fetched successfully', 201);
    }

     public function getslider()
    {
        $banners = Banner::select('id','product_img','product_ben_img','redirect_url')->where('type','benefit')
        ->get()
          ->map(function ($banner) {
            return [
                'id'         => $banner->id,
                'url'        => $banner->redirect_url,
                'image' => url('storage/' . $banner->product_img),
                'benefit_image' => url('storage/' . $banner->product_ben_img),
            ];
        });
        return ResponseBuilder::success($banners, 'Slider fetched successfully', 201);
    }

     public function getVideoList()
    {
        $banners = HomeVideo::select('id','first_video','second_video','third_video')->get();
        return ResponseBuilder::success($banners, 'Videos fetched successfully', 201);
    }

    public function getAllCategories()
    {
        $categories = Category::select('id', 'name')->where('feature_in_banner',0)->get();
        return ResponseBuilder::success($categories, 'Categories fetched successfully', 201);
    }

     public function getCategoriesBanners()
    {
        $categories = Category::select('id', 'image')->where('feature_in_banner',1)->get();
        return ResponseBuilder::success($categories, 'Categories fetched successfully', 201);
    }


}
