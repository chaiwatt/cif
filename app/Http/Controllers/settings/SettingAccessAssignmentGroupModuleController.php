<?php

namespace App\Http\Controllers\Settings;

use App\Models\Job;
use App\Models\Role;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\RoleGroupJson;
use App\Models\GroupModuleJob;
use App\Http\Controllers\Controller;

class SettingAccessAssignmentGroupModuleController extends Controller
{
    /**
     * แสดงหน้าสำหรับดูรายละเอียดของบทบาท
     *
     * @param int $id ไอดีของบทบาท
     * @return \Illuminate\Contracts\View\View
     */
    public function view($id)
    {
        // ค้นหาบทบาทด้วยไอดีที่กำหนด
        $role = Role::findOrFail($id);

        // ค้นหากลุ่มที่เกี่ยวข้องกับบทบาท
        $groups = RoleGroupJson::where('role_id', $id)->get();

        // ส่งข้อมูลกลุ่มและบทบาทไปยังหน้าวิวเพื่อแสดงผล
        return view('setting.access.assignment.group-module.view', [
            'groups' => $groups,
            'role' => $role
        ]);
    }

    /**
     * บันทึกข้อมูลกลุ่มที่กำหนดให้กับบทบาท
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลที่ส่งมา
        $request->validate([
            'data.selectedGroupIds' => 'required|array',
            'data.selectedGroupIds.*' => 'exists:groups,id',
            'data.roleId' => 'required|exists:roles,id',
        ]);

        // ดึงข้อมูลกลุ่มและไอดีของบทบาทจากคำขอ
        $groupIds = $request->data['selectedGroupIds'];
        $roleId = $request->data['roleId'];

        // วนลูปผ่านกลุ่มที่กำหนดและดำเนินการเพิ่มข้อมูลในตาราง RoleGroupJson
        foreach ($groupIds as $groupId) {
            $roleGroupJson = RoleGroupJson::where('group_id', $groupId)->where('role_id', $roleId)->first();
            if (!$roleGroupJson) {
                $jsonData = [];
                $data = GroupModuleJob::where('group_id', $groupId)->get();
                foreach ($data as $row) {
                    $module_obj = Module::find($row->module_id);
                    $job_obj = Job::find($row->job_id);

                    $module = [
                        "module_id" => $module_obj->id,
                        "module_name" => $module_obj->name,
                        "enable" => true,
                        "jobs" => []
                    ];

                    $existingModule = array_filter($jsonData, function ($item) use ($module) {
                        return $item['module_id'] === $module['module_id'];
                    });

                    if (count($existingModule) > 0) {
                        $existingModuleIndex = key($existingModule);
                        $jsonData[$existingModuleIndex]['jobs'][] = [
                            "job_id" => $job_obj->id,
                            "job_name" => $job_obj->name,
                            "permissions" => [
                                "show" => $row->show == 1 ? true : false,
                                "create" => $row->create == 1 ? true : false,
                                "update" => $row->update == 1 ? true : false,
                                "delete" => $row->delete == 1 ? true : false
                            ]
                        ];
                    } else {
                        $module['jobs'][] = [
                            "job_id" => $job_obj->id,
                            "job_name" => $job_obj->name,
                            "permissions" => [
                                "show" => $row->show == 1 ? true : false,
                                "create" => $row->create == 1 ? true : false,
                                "update" => $row->update == 1 ? true : false,
                                "delete" => $row->delete == 1 ? true : false
                            ]
                        ];
                        $jsonData[] = $module;
                    }
                }
                $jsonString = json_encode($jsonData);
                RoleGroupJson::create([
                    'role_id' => $roleId,
                    'group_id' => $groupId,
                    'json' => $jsonString,
                ]);
            }
        }

        // ส่งคำตอบกลับในรูปแบบ JSON
        return response()->json(['message' => 'กลุ่มถูกกำหนดให้กับบทบาทเรียบร้อยแล้ว']);
    }

    /**
     * ลบกลุ่มที่ถูกกำหนดให้กับบทบาท
     *
     * @param int $roleId ไอดีของบทบาท
     * @param int $groupId ไอดีของกลุ่ม
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($roleId, $groupId)
    {
        // ลบข้อมูลในตาราง RoleGroupJson โดยใช้ไอดีของบทบาทและกลุ่มที่กำหนด
        RoleGroupJson::where('role_id', $roleId)->where('group_id', $groupId)->delete();

        // ส่งคำตอบกลับในรูปแบบ JSON
        return response()->json(['message' => 'กลุ่มถูกลบออกจากบทบาทเรียบร้อยแล้ว']);
    }

    /**
     * อัปเดตข้อมูล JSON ของโมดูลในกลุ่มที่กำหนดให้กับบทบาท
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateModuleJson(Request $request)
    {
        // รับข้อมูล JSON และไอดีของบทบาทและกลุ่มจากคำขอ
        $jsonData = $request->data['updatedValues'];
        $roleId = $request->data['roleId'];
        $groupId = $request->data['groupId'];

        // ค้นหาข้อมูล RoleGroupJson ด้วยไอดีของบทบาทและกลุ่ม
        $roleGroupJson = RoleGroupJson::where('role_id', $roleId)->where('group_id', $groupId)->first();

        // อัปเดตข้อมูล JSON และบันทึก
        $roleGroupJson->json = $jsonData;
        $roleGroupJson->save();

        // ส่งคำตอบกลับในรูปแบบ JSON พร้อมกับข้อมูล JSON ที่อัปเดต
        return response()->json(['message' => $roleGroupJson->json]);
    }
}
