<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\RoleGroupJson;
use App\Http\Controllers\Controller;

class SettingAssignmentModuleController extends Controller
{
    /**
     * อัปเดตข้อมูล JSON ของโมดูลในกลุ่มที่กำหนดให้กับบทบาท
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateModuleJson(Request $request)
    {
        // รับข้อมูล JSON และไอดีของบทบาทและกลุ่มจากคำขอ
        $jsonData = $request->json_data;
        $roleId = $request->role_id;
        $groupId = $request->group_id;

        // ค้นหาข้อมูล RoleGroupJson ด้วยไอดีของบทบาทและกลุ่ม
        $roleGroupJson = RoleGroupJson::where('role_id', $roleId)->where('group_id', $groupId)->first();

        // อัปเดตข้อมูล JSON และบันทึก
        $roleGroupJson->json = $jsonData;
        $roleGroupJson->save();

        // ส่งคำตอบกลับในรูปแบบ JSON พร้อมกับข้อมูล JSON ที่อัปเดต
        return response()->json(['message' => $roleGroupJson->json]);
    }
}
