<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    public function index(Request $request){
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

    public function create_banner(Request $request){
        return view('banner.add');
    }
}
