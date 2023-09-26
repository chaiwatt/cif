<?php

namespace App\Http\Controllers\AnnouncementSystem;

use Countable;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\AnnouncementAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class AnnounceSystemAnnouncementListController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }
    public function index()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        $announcements = Announcement::orderBy('id', 'desc')->get();
        
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'announcements' => $announcements
       ]);
    }
    public function create()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        // dd('ok');
        return view('groups.announcement-system.announcement.list.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission
        ]);
    }
    public function store(Request $request)
    {
       
        $validator = $this->validateFormData($request);
       
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $title = $request->title;
        $description = $request->description;
        $body = $request->summernoteContent;
        $attachments = $request->attachments;
        $status = $request->status;
         
        $announcement = Announcement::create([
            'title' => $title,
            'description' => $description,
            'body' => $body,
            'status' => $status,
        ]);
        

        if (isset($attachments) && (is_array($attachments) || $attachments instanceof Countable)) {
            foreach($attachments as $attachment){
                $filePath = $attachment->store('', 'attachments');
                AnnouncementAttachment::create([
                    'name' => $attachment->getClientOriginalName(),
                    'announcement_id' => $announcement->id,
                    'file' => $filePath
                ]);
            }
        }

    }
    public function view($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'update'
        $action = 'update';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $announcement = Announcement::find($id);
        $announcementAttachments = AnnouncementAttachment::where('announcement_id',$id)->get();

        return view('groups.announcement-system.announcement.list.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'announcement' => $announcement,
            'announcementAttachments' => $announcementAttachments 
        ]);
    }
    public function deleteAttachment(Request $request)
    {
        $announceAttachmentId = $request->data['announceAttachmentId'];
        $announcementAttachment = AnnouncementAttachment::find($announceAttachmentId);
        Storage::disk('attachments')->delete($announcementAttachment->file);
        $announcementAttachment->delete();
    }
    public function update(Request $request){
        // ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
        $validator = $this->validateFormData($request);
        if ($validator->fails()) {
            // ในกรณีที่ข้อมูลไม่ถูกต้อง กลับไปยังหน้าก่อนหน้าพร้อมแสดงข้อผิดพลาดและข้อมูลที่กรอก
            return redirect()->back()->withErrors($validator)->withInput();
        }
       
        $announcementId = $request->announcementId;
        $title = $request->title;
        $description = $request->description;
        $body = $request->summernoteContent;
        $attachments = $request->attachments;
        $status = $request->status;

        Announcement::find($announcementId)->update([
            'title' => $title,
            'description' => $description,
            'body' => $body,
            'status' => $status
        ]);
        
        if (isset($attachments) && (is_array($attachments) || $attachments instanceof Countable)) {
            foreach($attachments as $attachment){
                $filePath = $attachment->store('', 'attachments');
                AnnouncementAttachment::create([
                    'name' => $attachment->getClientOriginalName(),
                    'announcement_id' => $announcementId,
                    'file' => $filePath
                ]);
            }
        }
        
        return ;
    }
    public function delete($id)
    {
        $announceAttachments = AnnouncementAttachment::where('announcement_id', $id)->get();
        // Delete records and associated files
        foreach ($announceAttachments as $announceAttachment) {
            Storage::disk('attachments')->delete($announceAttachment->file);
            $announceAttachment->delete();
        }
        
        $announcement = Announcement::findOrFail($id);

        $this->activityLogger->log('ลบ', $announcement);

        $announcement->delete();

        return response()->json(['message' => 'ข่าวประกาศได้ถูกลบออกเรียบร้อยแล้ว']);
    }
    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }
}
