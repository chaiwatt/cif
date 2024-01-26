<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    public function announce_thumbnail_view($image) {
        $path = storage_path('app/announcement/thumbnail/' . $image);
        $file = \File::get($path);
        $type = \File::mimeType($path);
        $response = \Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    }
    public function announce_attachment_view($file) {
        $path = storage_path('app/announcement/attachments/' . $file);
        $file = \File::get($path);
        $type = \File::mimeType($path);
        $response = \Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    }
    public function avatar_view($image) {
        $path = storage_path('app/avatar/' . $image);
        $file = \File::get($path);
        $type = \File::mimeType($path);
        $response = \Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    }
}
