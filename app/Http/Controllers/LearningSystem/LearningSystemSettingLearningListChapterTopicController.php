<?php

namespace App\Http\Controllers\LearningSystem;

use Countable;
use App\Models\Topic;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\TopicAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\UpdatedRoleGroupCollectionService;

class LearningSystemSettingLearningListChapterTopicController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->activityLogger = $activityLogger;
    }
    public function index($id)
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
        $chapter = Chapter::find($id);
        
        // $lessons = Lesson::find($id);
        
        return view('groups.learning-system.setting.learning-list.chapter.topic.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'chapter' => $chapter
       ]);
    }
    public function create($id)
    {
      
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'create';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $chapter = chapter::find($id);

        return view('groups.learning-system.setting.learning-list.chapter.topic.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'chapter' => $chapter
        ]);
    }
    public function store(Request $request)
    {
        $validator = $this->validateFormData($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $name = $request->name;
        $chapterId = $request->chapterId;
        $body = $request->summernoteContent;
        $attachments = $request->attachments;

        $topic = Topic::create([
            'name' => $name,
            'chapter_id' => $chapterId,
            'body' => $body,
        ]);

        if (isset($attachments) && (is_array($attachments) || $attachments instanceof Countable)) {
            foreach($attachments as $attachment){
                $filePath = $attachment->store('', 'attachments');
                TopicAttachment::create([
                    'name' => $attachment->getClientOriginalName(),
                    'topic_id' => $topic->id,
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
        $topic = Topic::find($id);
        $topicAttachments = TopicAttachment::where('topic_id',$id)->get();

        return view('groups.learning-system.setting.learning-list.chapter.topic.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'topic' => $topic,
            'topicAttachments' => $topicAttachments 
        ]);
    }
    public function update(Request $request){
        // ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
        $validator = $this->validateFormData($request);
        if ($validator->fails()) {
            // ในกรณีที่ข้อมูลไม่ถูกต้อง กลับไปยังหน้าก่อนหน้าพร้อมแสดงข้อผิดพลาดและข้อมูลที่กรอก
            return redirect()->back()->withErrors($validator)->withInput();
        }
       
        $name = $request->name;
        $chapterId = $request->chapterId;
        $body = $request->summernoteContent;
        $attachments = $request->attachments;
        $topicId = $request->topicId;

        Topic::find($topicId)->update([
            'name' => $name,
            'body' => $body,
        ]);
        
        if (isset($attachments) && (is_array($attachments) || $attachments instanceof Countable)) {
            foreach($attachments as $attachment){
                $filePath = $attachment->store('', 'attachments');
                TopicAttachment::create([
                    'name' => $attachment->getClientOriginalName(),
                    'topic_id' => $topicId,
                    'file' => $filePath
                ]);
            }
        }
        
        
        // $name = $request->name;
        // $chapterId = $request->chapterId;
        // Topic::find($id)->update([
        //     'name' => $name
        // ]);
        return redirect()->route('groups.learning-system.setting.learning-list.chapter.topic', [
            'id' => $chapterId
        ]);
    }
    public function deleteAttachment(Request $request)
    {
        $topicAttachmentId = $request->data['topicAttachmentId'];
        $topicAttachment = TopicAttachment::find($topicAttachmentId);
        Storage::disk('attachments')->delete($topicAttachment->file);
        $topicAttachment->delete();
    }
    public function delete($id)
    {
        $topicAttachments = TopicAttachment::where('topic_id', $id)->get();
        // Delete records and associated files
        foreach ($topicAttachments as $attachment) {
            Storage::disk('attachments')->delete($attachment->file);
            $attachment->delete();
        }
        
        $topic = Topic::findOrFail($id);

        $this->activityLogger->log('ลบ', $topic);

        $topic->delete();

        return response()->json(['message' => 'รายละเอียดการเรียนรู้ได้ถูกลบออกเรียบร้อยแล้ว']);
    }
    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }
}
