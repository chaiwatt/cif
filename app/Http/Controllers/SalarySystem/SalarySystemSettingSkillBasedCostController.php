<?php

namespace App\Http\Controllers\SalarySystem;

use Illuminate\Http\Request;
use App\Models\SkillBasedCost;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Services\UpdatedRoleGroupCollectionService;
use Illuminate\Support\Facades\Validator;

class SalarySystemSettingSkillBasedCostController extends Controller
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
        $skillBasedCosts = SkillBasedCost::all();

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'skillBasedCosts' => $skillBasedCosts
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
        $skillBasedCosts = SkillBasedCost::all();

        return view('groups.salary-system.setting.skill-based-cost.create', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'skillBasedCosts' => $skillBasedCosts
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->validateFormData($request);
        $name = $request->name;
        $cost = $request->cost;

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        SkillBasedCost::create([
            'name' => $name,
            'cost' => $cost,
        ]);
        return redirect()->route('groups.salary-system.setting.skill-based-cost');
    }

    public function view($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'update'
        $action = 'update';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $skillBasedCost = SkillBasedCost::find($id);

        return view('groups.salary-system.setting.skill-based-cost.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'skillBasedCost' => $skillBasedCost
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateFormData($request);
        $name = $request->name;
        $cost = $request->cost;
        $skillBasedCost = SkillBasedCost::find($id);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $skillBasedCost->update([
            'name' => $name,
            'cost' => $cost,
        ]);
        return redirect()->route('groups.salary-system.setting.skill-based-cost');
    }

    
    public function delete($id)
    {
        $skillBasedCost = SkillBasedCost::findOrFail($id);

        $this->activityLogger->log('ลบ', $skillBasedCost);

        $skillBasedCost->delete();

        return response()->json(['message' => 'รายการทักษะได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    function validateFormData($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'cost' => 'required',
        ]);
        return $validator;
    }
}
