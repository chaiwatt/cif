<?php

namespace App\Http\Controllers;

use App\Models\LeaveIncrement;
use App\Models\LeaveType;
use App\Models\UserLeave;
use Illuminate\Http\Request;

class UserManagementSystemSettingUserInfoUserLeaveController extends Controller
{
    public function updateUserLeave(Request $request){
        $userLeaveId = $request->data['userLeaveId'];
        $leave = $request->data['leave'];
        $userId = $request->data['userId'];
        UserLeave::find($userLeaveId)->update(['count' => $leave]);
        $userLeaves = UserLeave::where('user_id',$userId)->get();

        return view('groups.user-management-system.setting.userinfo.table-render.user-leave-table-render',[
            'userLeaves' => $userLeaves
            ])->render();
    }

    public function updateLeaveIncrement(Request $request)
{
    $userId = $request->data['userId'];
    $jsonData = $request->data['jsonData'];

    foreach ($jsonData as $item) {
        $leaveIncrement = LeaveIncrement::where('user_id', $userId)
            ->where('leave_type_id', $item['id'])
            ->first();

        if ($leaveIncrement) {
            // อัปเดตข้อมูล leaveType จาก JSON
            $leaveIncrement->type = $item['type'];
            $leaveIncrement->quantity = $item['quantity'];

            // อัปเดตข้อมูลเดือน
            $leaveIncrement->months = json_encode($item['months']);

            $leaveIncrement->save();
        }
    }

    // สามารถเพิ่มการตอบกลับหรือการตัดสินใจต่อไปได้ตามที่ท่านต้องการ
    return response()->json(['message' => 'Leave increments updated successfully']);
}
}
