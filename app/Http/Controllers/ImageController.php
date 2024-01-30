<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //
    public function announce_thumbnail_view($image) {
        $path = storage_path('app/announcement/thumbnails/' . $image);
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
    public function announce_attachment_download($file) {
        return Storage::disk('announcement-attachments')->download($file);
    }
    public function avatar_view($image) {
        $path = storage_path('app/avatar/' . $image);
        $file = \File::get($path);
        $type = \File::mimeType($path);
        $response = \Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    }
    public function topic_attachment_view($file) {
        $path = storage_path('app/topic-attachments/' . $file);
        $file = \File::get($path);
        $type = \File::mimeType($path);
        $response = \Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    }
    public function topic_attachment_download($file) {
        return Storage::disk('topic-attachments')->download($file);
    }
}
