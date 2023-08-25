<?php

namespace App\Http\Controllers\UserManagementSystem;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Punishment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementSystemSettingUserInfoPunishmentController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request->data['userId'];
        $punishment = $request->data['puhishment'];
        $puhishmentRecordDate = $request->data['puhishmentRecordDate'];

        Punishment::create([
            'user_id' => $userId,
            'punishment' => $punishment,
            'record_date' =>  Carbon::createFromFormat('d/m/Y', $puhishmentRecordDate)->format('Y-m-d'), 
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.punishment-render',[
            'user' => $user
            ])->render();
    }
    public function getPunishment(Request $request)
    {
        $punishmentId = $request->data['punishmentId'];
        $punishment = Punishment::find($punishmentId);
        return response()->json($punishment);
    }

    public function updatePunishment(Request $request)
    {
        $userId = $request->data['userId'];
        $punishment = $request->data['puhishment'];
        $puhishmentRecordDate = $request->data['puhishmentRecordDate'];
        $punishmentId = $request->data['punishmentId'];
        // dd($userId,$punishment,$puhishmentRecordDate,$punishmentId);
        Punishment::find($punishmentId)->update([
            'user_id' => $userId,
            'punishment' => $punishment,
            'record_date' =>  Carbon::createFromFormat('d/m/Y', $puhishmentRecordDate)->format('Y-m-d'), 
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.punishment-render',[
            'user' => $user
            ])->render();
    }

    public function delete(Request $request)
    {
        $userId = $request->data['userId'];
        $punishmentId = $request->data['punishmentId'];
        Punishment::find($punishmentId)->delete();
         $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.punishment-render',[
            'user' => $user
            ])->render();
    }

}
