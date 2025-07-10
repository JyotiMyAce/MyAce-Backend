<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    protected $errorStatus       = 500;
    protected $successStatus     = 200;
    protected $validationStatus  = 400;
    protected $unauthStatus      = 401;
    protected $notFoundStatus    = 404;
    protected $invalidPermission = 403;

    // protected function __imageSave($request, $key = '', $folder_name = '', $old_img = ''): ?string
    // {
    //     $fileName = null;
    //     if ($request->hasFile($key) && !empty($key) && !empty($folder_name)) {
    //         $image = $request->file($key);
    //         $originalName = $image->getClientOriginalName();
    //         $file_name = time() . '_' . $originalName; // Create unique filename
    //         $fileName = $image->storeAs($folder_name, $file_name);
    //         if (!empty($old_img)) {
    //             if (Storage::exists($old_img)) {
    //                 Storage::delete($old_img);
    //             }
    //         }
    //     }

    //     return $fileName ?: null; 
    // }

    protected function __imageSave($request, $key = '', $folder_name = '', $old_img = ''): ?string
    {
        $fileName = null;
        if ($request->hasFile($key) && !empty($key) && !empty($folder_name)) {
            $file = $request->file($key);
            $originalName = $file->getClientOriginalName();
            $file_name = time() . '_' . $originalName; // Create unique filename
            $fileName = $file->storeAs($folder_name, $file_name, 'public'); // Explicitly use public disk
            if (!empty($old_img) && Storage::disk('public')->exists($old_img)) {
                Storage::disk('public')->delete($old_img);
            }
        }

        return $fileName ?: null;
    }
}
