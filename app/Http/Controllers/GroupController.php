<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Group;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\RoleGroupJson;
use App\Services\AccessGroupService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;


class GroupController extends Controller
{
    private $accessGroupService;

    public function __construct(AccessGroupService $accessGroupService)
    {
        $this->accessGroupService = $accessGroupService;
    }

    /**
     * แสดงหน้าแดชบอร์ดสำหรับกลุ่มที่กำหนดด้วย ID ที่ระบุ
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index($id)
    {
        $user = auth()->user();
        $group = Group::findOrFail($id);

        // ตรวจสอบสิทธิ์การเข้าถึงของผู้ใช้ในกลุ่ม
        $this->accessGroupService->hasAccess($user, $group);

        // กำหนดค่าใน session
        session(['userGroupId' => $id]);
        session(['groupUrl' => url()->current()]);

        $role = $user->roles->first();

        // ตรวจสอบข้อมูล RoleGroupJson สำหรับบทบาทและกลุ่มที่กำหนด
        $roleGroup = RoleGroupJson::where('role_id', $role->id)->where('group_id', $id)->first();
        if (!$roleGroup) {
            return redirect()->route('home')->with('error', 'คุณยังไม่ได้รับมอบหมายบทบาทสำหรับกลุ่มทำงาน');
        }

        $roleGroupJson = json_decode($roleGroup->json);
        $roleGroupCollection = collect($roleGroupJson);

        // อัปเดตคอลเล็กชัน RoleGroupJson โดยกรองและแมปข้อมูล
        $updatedRoleGroupCollection = $roleGroupCollection
            ->filter(function ($module) {
                return $module->enable === true || $module->enable === "true";
            })
            ->map(function ($module) {
                $module->jobs = collect($module->jobs)->map(function ($job) {
                    $jobModel = Job::find($job->job_id);
                    $job->job_view = $jobModel->view;
                    $job->job_route = $jobModel->route;
                    return $job;
                });
                $moduleModel = Module::find($module->module_id);
                $module->module_icon = $moduleModel->icon;
                return $module;
            });

        $group = Group::findOrFail($id);

        return view('groups.index', [
            'group' => $group,
            'modules' => $updatedRoleGroupCollection,
            'groupUrl' => url()->current()
        ]);
    }

}
