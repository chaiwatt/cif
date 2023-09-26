<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\ApplicationNew;
use App\Models\AnnouncementAttachment;
use App\Models\ApplicationNewAttachment;

class LandingController extends Controller
{
    public function index(){
        $announcements = Announcement::orderBy('id', 'desc')->get();
        $applicationNews = ApplicationNew::orderBy('id', 'desc')->get();
        return view('landing',[
            'announcements' => $announcements,
            'applicationNews' => $applicationNews
        ]);
    }
    public function postAnnouncement($id){
        $announcement = Announcement::find($id);
        $announcementAttachments = AnnouncementAttachment::where('announcement_id',$id)->get();
        return view('post-announcement',[
            'announcement' => $announcement,
            'announcementAttachments' => $announcementAttachments
        ]);
    }
    public function postJobApplicationNews($id){
        $applicationNew = ApplicationNew::find($id);
        $applicationNewAttachments = ApplicationNewAttachment::where('application_new_id',$id)->get();
        return view('post-job-application-news',[
            'applicationNew' => $applicationNew,
            'applicationNewAttachments' => $applicationNewAttachments
        ]);
    }
}
