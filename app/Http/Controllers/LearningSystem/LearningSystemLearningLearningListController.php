<?php

namespace App\Http\Controllers\LearningSystem;

use App\Models\Topic;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\TopicAttachment;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;

class LearningSystemLearningLearningListController extends Controller
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
        $lessons = Lesson::all();
        
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'lessons' => $lessons
       ]);
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
        $lesson = Lesson::find($id);

        return view('groups.learning-system.learning.learning-list.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'lesson' => $lesson,
        ]);
    }

    public function content(Request $request){
        $topicId = $request->data['topicId'];
        $topic = Topic::find($topicId);
        $topicAttachments = TopicAttachment::where('topic_id',$topicId)->get();
        return view('groups.learning-system.learning.learning-list.content-render.content', [
        'topic' => $topic,
        'topicAttachments' => $topicAttachments,
        ])->render();
    }
}
