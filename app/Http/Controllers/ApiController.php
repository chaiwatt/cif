<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\RoleGroupJson;
use App\Models\RoleUser;

class ApiController extends Controller
{
    /**
     * รับข้อมูลกลุ่มทั้งหมดและส่งกลับเป็น JSON
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroup()
    {
        $groups = Group::all();
        return response()->json($groups);
    }

    /**
     * รับข้อมูลโมดูลเป็น JSON โดยใช้ข้อมูลของบทบาทและกลุ่ม
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getModuleJson(Request $request)
    {
        $roleId = $request->role_id;
        $groupId = $request->group_id;
        $rolegroupjson = RoleGroupJson::where('role_id', $roleId)->where('group_id', $groupId)->first()->json;
        return response()->json($rolegroupjson);
    }

    /**
     * รับข้อมูลผู้ใช้ที่ยังไม่มีบทบาทและส่งกลับเป็น JSON
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser()
    {
        $usersWithRoles = RoleUser::pluck('user_id');
        $users = User::whereNotIn('id', $usersWithRoles)->where('employee_type_id', 1)->with('company_department')->get();
        return response()->json($users);
    }

}
