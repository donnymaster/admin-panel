<?php

namespace App\Http\Controllers\AdminPanel;

use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageProcessingController extends Controller
{
    public function save(Request $request)
    {
        // dd($request->file('image')->getPathName());
        // $filePath = $request->file('image')->store('/pages/21');
        // dd(storage_path($filePath));
        Image::load('/pages/21/ZPK0YuypgSZkKycA1xHO9LFUFwnnmCmjBPmLRQYW.jpg')->format(Manipulations::FORMAT_WEBP)->save();
    }
}
