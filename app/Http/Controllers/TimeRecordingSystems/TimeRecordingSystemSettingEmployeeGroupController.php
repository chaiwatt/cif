<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemSettingEmployeeGroupController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $addDefaultWorkScheduleAssignment;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService, AddDefaultWorkScheduleAssignment $addDefaultWorkScheduleAssignment,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->addDefaultWorkScheduleAssignment = $addDefaultWorkScheduleAssignment;
        $this->activityLogger = $activityLogger;
    }

    public function index()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];

        // ค้นหาข้อมูล UserGroup ทั้งหมด และเก็บในตัวแปร $userGroups
        $userGroups = UserGroup::all();

        // ส่งค่าตัวแปรไปยัง view ที่กำหนดในตัวแปร $viewName
        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'userGroups' => $userGroups
        ]);
    }

    public function create()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'create'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        return view('groups.time-recording-system.setting.employee-group.create',[
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
        ]);
    }

    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลที่ส่งมาตรงกับเงื่อนไขที่กำหนดใน validateFormData
        $validator = $this->validateFormData($request);

        // ถ้าการตรวจสอบไม่ผ่าน
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // สร้างตัวแปร UserGroup และกำหนดค่า name จากข้อมูลที่ส่งมา
        $userGroup = new UserGroup();
        $userGroup->name = $request->name;
        $userGroup->save();

        return redirect()->route('groups.time-recording-system.setting.employee-group');
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
        $userGroup = UserGroup::find($id);
        return view('groups.time-recording-system.setting.employee-group.view',[
            'userGroup' => $userGroup,
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userGroup = UserGroup::findOrFail($id);

        $this->activityLogger->log('อัปเดต', $userGroup);

        $userGroup->update([
            'name' => $request->name
        ]);

        return redirect()->route('groups.time-recording-system.setting.employee-group');
    }

      public function delete($id)
    {
        $userGroup = UserGroup::findOrFail($id);

        $this->activityLogger->log('ลบ', $userGroup);

        $userGroup->delete();

        return response()->json(['message' => 'กลุ่มพนักงานได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        return $validator;
    }

}
