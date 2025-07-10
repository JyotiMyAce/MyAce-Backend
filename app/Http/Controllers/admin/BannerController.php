<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::latest()->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('DT_RowId', function ($row) {
                    return $row->id;
                })
                ->addColumn('action', function ($row) {
                    $btn = '';

                    $btn .= '<a href="' . route('admin.banner.edit', $row->id) . '" class="btn btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" data-id ="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Delete" data-datatable = "featuresTable" data-url = "' . route('admin.banner.delete') . '" class="btn  btn-xs  deletemodel "><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d M y, g:i A');
                    // return $this->convertToSouthAfricaTime($row->created_at);
                })
                ->rawColumns(['action', 'created_at'])
                ->make(true);
        }
        return view('banner.index');
    }

    public function create_banner(Request $request)
    {
        return view('banner.add');
    }

    public function insert_banner(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'banner_type' => 'required|in:banner,benefit,video',
                'redirect_url' => [
                    'nullable',
                    'url',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->banner_type !== 'video' && empty($value)) {
                            $fail('The redirect URL is required unless the type is video.');
                        }
                    }
                ],
                'banner_img' => [
                    'required_if:banner_type,banner',
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:2048'
                ],
                'product_img' => [
                    'required_if:banner_type,benefit',
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:2048'
                ],
                'product_ben_img' => [
                    'required_if:banner_type,benefit',
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:2048'
                ],
                'video' => [
                    'required_if:banner_type,video',
                    'nullable',
                    'mimes:mp4,avi,mov,webm',
                    'max:10240' // 10MB max
                ],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'serverside_error',
                    'msg' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }
            $user = Auth::guard('admin')->user();

            // Prepare the banner record
            $banner = new Banner();
            $banner->user_id = $user->id;
            $banner->type = $request->banner_type;
            $banner->redirect_url = $request->redirect_url;

            // File uploads
            if ($request->hasFile('banner_img')) {
                $banner->banner_img = $this->__imageSave($request, 'banner_img', 'banners');
            }

            if ($request->hasFile('product_img')) {
                $banner->product_img = $this->__imageSave($request, 'product_img', 'banners/product');
            }

            if ($request->hasFile('product_ben_img')) {
                $banner->product_ben_img = $this->__imageSave($request, 'product_ben_img', 'banners/product');
            }

            if ($request->hasFile('video')) {
                $banner->video = $request->file('video')->store('videos', 'public');
            }

            $banner->save();

            return response()->json([
                'status' => 'success',
                'msg' => 'Banner added successfully.',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Database error: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit_banner(Request $request, $id)
    {
        $bannerData = Banner::find($id);
        return view('banner.add', compact('bannerData'));
    }

    public function update_banner(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'banner_id' => 'required|exists:banners,id',
                'banner_type' => 'required|in:banner,benefit,video',
                'redirect_url' => [
                    'nullable',
                    'url',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->banner_type !== 'video' && empty($value)) {
                            $fail('The redirect URL is required unless the type is video.');
                        }
                    }
                ],
                'banner_img' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:2048',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->banner_type === 'banner' && !$request->hasFile('banner_img') && !$request->input('remove_banner_img') && !Banner::find($request->banner_id)->banner_img) {
                            $fail('The banner image is required when type is banner.');
                        }
                    }
                ],
                'product_img' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:2048',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->banner_type === 'benefit' && !$request->hasFile('product_img') && !$request->input('remove_product_img') && !Banner::find($request->banner_id)->product_img) {
                            $fail('The product image is required when type is benefit.');
                        }
                    }
                ],
                'product_ben_img' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:2048',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->banner_type === 'benefit' && !$request->hasFile('product_ben_img') && !$request->input('remove_product_ben_img') && !Banner::find($request->banner_id)->product_ben_img) {
                            $fail('The product benefit image is required when type is benefit.');
                        }
                    }
                ],
                'video' => [
                    'nullable',
                    'mimes:mp4,avi,mov,webm',
                    'max:10240', // 10MB max
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->banner_type === 'video' && !$request->hasFile('video') && !$request->input('remove_video') && !Banner::find($request->banner_id)->video) {
                            $fail('The video is required when type is video.');
                        }
                    }
                ],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'serverside_error',
                    'msg' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = Auth::guard('admin')->user();
            $banner = Banner::findOrFail($request->banner_id);

            // Prevent updating banner_type
            if ($banner->type !== $request->banner_type) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Banner type cannot be updated.',
                ], 422);
            }

            // Update redirect_url
            $banner->redirect_url = $request->redirect_url;

            // Handle file uploads and removals
            if ($request->has('remove_banner_img') && $request->input('remove_banner_img') == '1' && $banner->banner_img) {
                $banner->banner_img = $this->__imageSave($request, 'banner_img', 'banners', $banner->banner_img);
            } elseif ($request->hasFile('banner_img')) {
                $banner->banner_img = $this->__imageSave($request, 'banner_img', 'banners', $banner->banner_img);
            }

            if ($request->has('remove_product_img') && $request->input('remove_product_img') == '1' && $banner->product_img) {
                $banner->product_img = $this->__imageSave($request, 'product_img', 'banners/product', $banner->product_img);
            } elseif ($request->hasFile('product_img')) {
                $banner->product_img = $this->__imageSave($request, 'product_img', 'banners/product', $banner->product_img);
            }

            if ($request->has('remove_product_ben_img') && $request->input('remove_product_ben_img') == '1' && $banner->product_ben_img) {
                $banner->product_ben_img = $this->__imageSave($request, 'product_ben_img', 'banners/product', $banner->product_ben_img);
            } elseif ($request->hasFile('product_ben_img')) {
                $banner->product_ben_img = $this->__imageSave($request, 'product_ben_img', 'banners/product', $banner->product_ben_img);
            }

            if ($request->has('remove_video') && $request->input('remove_video') == '1' && $banner->video) {
                $banner->video = $this->__imageSave($request, 'video', 'videos', $banner->video);
            } elseif ($request->hasFile('video')) {
                $banner->video = $this->__imageSave($request, 'video', 'videos', $banner->video);
            }

            $banner->save();

            return response()->json([
                'status' => 'success',
                'msg' => 'Banner updated successfully.',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Database error: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
}
