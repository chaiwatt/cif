<?php

namespace App\Http\Controllers\UserManagementSystem;

use App\Models\User;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementSystemSettingUserInfoEducationController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request->data['userId'];
        $educationLevel = $request->data['educationLevel'];
        $educationBranch = $request->data['educationBranch'];
        $graduatedYear = $request->data['graduatedYear'];

        Education::create([
            'user_id' => $userId,
            'level' => $educationLevel,
            'branch' => $educationBranch,
            'year' => $graduatedYear,
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.education-render',[
            'user' => $user
            ])->render();
    }

    public function getEducation(Request $request)
    {
        $educationId = $request->data['educationId'];
        $education = Education::find($educationId);
        return response()->json($education);
    }

    public function updateEducation(Request $request)
    {
        $userId = $request->data['userId'];
        $educationLevel = $request->data['educationLevel'];
        $educationBranch = $request->data['educationBranch'];
        $graduatedYear = $request->data['graduatedYear'];
        $educationId = $request->data['educationId'];

        Education::find($educationId)->update([
            'user_id' => $userId,
            'level' => $educationLevel,
            'branch' => $educationBranch,
            'year' => $graduatedYear,
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.education-render',[
            'user' => $user
            ])->render();
    }

    public function delete(Request $request)
    {
        $userId = $request->data['userId'];
        $educationId = $request->data['educationId'];
        Education::find($educationId)->delete();
         $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.education-render',[
            'user' => $user
            ])->render();
    }

}

