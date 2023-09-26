<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\ApplicationNew;

class LandingController extends Controller
{
    public function index(){
        $announcements = Announcement::all();
        $pplicationNews = ApplicationNew::all();
        // dd($announcements);
        return view('landing',[
            'announcements' => $announcements,
            'pplicationNews' => $pplicationNews
        ]);
    }
}
