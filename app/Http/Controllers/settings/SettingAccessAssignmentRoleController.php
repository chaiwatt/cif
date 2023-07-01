<?php

namespace App\Http\Controllers\settings;

use App\Models\Role;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;

class SettingAccessAssignmentRoleController extends Controller
{
    private $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->activityLogger = $activityLogger;
    }
    /**
     * บันทึกการมอบหมายบทบาทให้กับผู้ใช้งาน
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // รับข้อมูลรหัสผู้ใช้งานและรหัสบทบาทจากคำขอ
        $userIds = $request->data['selectedUserIds'];
        $roleId = $request->data['roleId'];
        $role = Role::find($roleId);

        // วนลูปเพื่อมอบหมายบทบาทให้กับผู้ใช้งานที่ระบุ
        foreach ($userIds as $userId) {
            $currentUser = User::find($userId);
            $currentUser->roles()->detach($role);
            $user = User::find($userId);
            $user->roles()->attach($role);
        }

        // ส่งคำตอบกลับในรูปแบบ JSON พร้อมกับข้อความแจ้งว่ามอบหมายบทบาทสำเร็จ
        return response()->json(['message' => 'มอบหมายบทบาทสำเร็จ']);
    }

    /**
     * ลบการมอบหมายบทบาทที่กำหนดให้กับผู้ใช้งาน
     *
     * @param int $roleId
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($roleId, $userId)
    {
        $user = User::find($userId);
        $role = Role::find($roleId);

        $this->activityLogger->log('ลบ', $role);

        $user->roles()->detach($role);

        // ส่งกลับไปยังหน้าก่อนหน้านี้
        return redirect()->back();
    }

}
