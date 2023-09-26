<?php

namespace App\Http\Controllers\JobApplication;

use Countable;
use Illuminate\Http\Request;
use App\Models\ApplicationNew;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\ApplicationNewAttachment;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class JobApplicationSystemJobApplicationListController extends Controller
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
        $applicationNews = ApplicationNew::orderBy('id', 'desc')->get();
        
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'applicationNews' => $applicationNews
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
        return view('groups.job-application-system.job-application.list.create', [
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

         
        $applicationNew = ApplicationNew::create([
            'title' => $title,
            'description' => $description,
            'body' => $body,
            'status' => $status,
        ]);
        

        if (isset($attachments) && (is_array($attachments) || $attachments instanceof Countable)) {
            foreach($attachments as $attachment){
                $filePath = $attachment->store('', 'attachments');
                ApplicationNewAttachment::create([
                    'name' => $attachment->getClientOriginalName(),
                    'application_new_id' => $applicationNew->id,
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
        $applicationNew = ApplicationNew::find($id);
        $applicationNewAttachments = ApplicationNewAttachment::where('application_new_id',$id)->get();

        return view('groups.job-application-system.job-application.list.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'applicationNew' => $applicationNew,
            'applicationNewAttachments' => $applicationNewAttachments 
        ]);
    }
    public function deleteAttachment(Request $request)
    {
        $applicationNewAttachmentId = $request->data['applicationNewAttachmentId'];
        $applicationNewAttachment = ApplicationNewAttachment::find($applicationNewAttachmentId);
        Storage::disk('attachments')->delete($applicationNewAttachment->file);
        $applicationNewAttachment->delete();
    }
    public function update(Request $request){
        // ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
        $validator = $this->validateFormData($request);
        if ($validator->fails()) {
            // ในกรณีที่ข้อมูลไม่ถูกต้อง กลับไปยังหน้าก่อนหน้าพร้อมแสดงข้อผิดพลาดและข้อมูลที่กรอก
            return redirect()->back()->withErrors($validator)->withInput();
        }
       
        $applicationNewId = $request->applicationNewId;
        $title = $request->title;
        $description = $request->description;
        $body = $request->summernoteContent;
        $attachments = $request->attachments;
        $status = $request->status;

        ApplicationNew::find($applicationNewId)->update([
            'title' => $title,
            'description' => $description,
            'body' => $body,
            'status' => $status,
        ]);
        
        if (isset($attachments) && (is_array($attachments) || $attachments instanceof Countable)) {
            foreach($attachments as $attachment){
                $filePath = $attachment->store('', 'attachments');
                ApplicationNewAttachment::create([
                    'name' => $attachment->getClientOriginalName(),
                    'application_new_id' => $applicationNewId,
                    'file' => $filePath
                ]);
            }
        }
        
        return ;
    }
    public function delete($id)
    {
        $applicationNewAttachments = ApplicationNewAttachment::where('application_new_id', $id)->get();
        // Delete records and associated files
        foreach ($applicationNewAttachments as $applicationNewAttachment) {
            Storage::disk('attachments')->delete($applicationNewAttachment->file);
            $applicationNewAttachment->delete();
        }
        
        $applicationNew = ApplicationNew::findOrFail($id);

        $this->activityLogger->log('ลบ', $applicationNew);

        $applicationNew->delete();

        return response()->json(['message' => 'ข่าวสมัครงานได้ถูกลบออกเรียบร้อยแล้ว']);
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
