<?php

namespace App\Http\Controllers\UserManagementSystem;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserDiligenceAllowance;
use App\Models\DiligenceAllowanceClassify;

class UserManagementSystemSettingUserInfDiligenceAllowanceClassifyController extends Controller
{
    public function getDiligenceAllowanceClassify(Request $request)
    {
        $userId = $request->data['userId'];
        
        // $userDiligenceAllowanceId = $request->data['userDiligenceAllowanceId'];

        $user = User::find($userId);
        $diligenceAllowanceClassifies = DiligenceAllowanceClassify::where('diligence_allowance_id',$user->diligence_allowance_id)->get();
        // dd($user->diligence_allowance_id);
        return view('groups.user-management-system.setting.userinfo.table-render.update-diligence-allowance-modal-render',[
            'diligenceAllowanceClassifies' => $diligenceAllowanceClassifies
            ])->render();
    }

    public function updateDiligenceAllowanceClassify(Request $request)
    {
        $userId = $request->data['userId'];
        $userDiligenceAllowanceId = $request->data['userDiligenceAllowanceId'];
        $diligenceAllowanceClassifyId = $request->data['diligenceAllowanceClassifyId'];
        UserDiligenceAllowance::find($userDiligenceAllowanceId)->update([
            'diligence_allowance_classify_id' => $diligenceAllowanceClassifyId
        ]);

        $userDiligenceAllowances = UserDiligenceAllowance::where('user_id', $userId)->orderBy('id', 'desc')->get();
        return view('groups.user-management-system.setting.userinfo.table-render.diligence-allowance-render',[
            'userDiligenceAllowances' => $userDiligenceAllowances
            ])->render();
    }
}
