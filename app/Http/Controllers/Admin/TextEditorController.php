<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TextEditorController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        if($request->file('file')) {
            $image = upload_image($request->file('file'), 'publikasi', 'image_content');
            return url($image);
        }

        return response()->json('message', 'Gambar tidak ditemukan');
    }

    public function deletePhoto(Request $request)
    {
        if($request->src) {
            $image = str_replace(url('/'), '', $request->src);
            File::delete($image);
            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus'
            ]);
        }
    }
}
