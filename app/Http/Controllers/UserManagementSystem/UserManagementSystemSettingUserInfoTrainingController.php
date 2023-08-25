<?php

namespace App\Http\Controllers\UserManagementSystem;

use App\Models\User;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementSystemSettingUserInfoTrainingController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request->data['userId'];
        $trainingCourse = $request->data['trainingCourse'];
        $trainingOrganizer = $request->data['trainingOrganizer'];
        $trainingYear = $request->data['trainingYear'];

        Training::create([
            'user_id' => $userId,
            'course' => $trainingCourse,
            'organizer' => $trainingOrganizer,
            'year' => $trainingYear,
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.training-render',[
            'user' => $user
            ])->render();
    }

    public function getTraining(Request $request)
    {
        $trainingId = $request->data['trainingId'];
        $training = Training::find($trainingId);
        return response()->json($training);
    }


    public function updateTraining(Request $request)
    {
        $userId = $request->data['userId'];
        $trainingCourse = $request->data['trainingCourse'];
        $trainingOrganizer = $request->data['trainingOrganizer'];
        $trainingYear = $request->data['trainingYear'];
        $trainingId = $request->data['trainingId'];

        Training::find($trainingId)->update([
            'user_id' => $userId,
            'course' => $trainingCourse,
            'organizer' => $trainingOrganizer,
            'year' => $trainingYear,
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.training-render',[
            'user' => $user
            ])->render();
    }

     public function delete(Request $request)
    {
        $userId = $request->data['userId'];
        $trainingId = $request->data['trainingId'];
        Training::find($trainingId)->delete();
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.training-render',[
            'user' => $user
            ])->render();
    }
}


