<?php

namespace App\Http\Controllers\UserManagementSystem;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserPosition;
use Illuminate\Http\Request;
use App\Models\PositionHistory;
use App\Http\Controllers\Controller;

class UserManagementSystemSettingUserInfoPositionController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request->data['userId'];
        $userPositionId = $request->data['position'];
        $positionAdjustDate = $request->data['positionAdjustDate'];
        // dd($positionAdjustDate);
        
        PositionHistory::create([
            'user_id' => $userId,
            'user_position_id' => $userPositionId,
            'adjust_date' => Carbon::createFromFormat('d/m/Y', $positionAdjustDate)->format('Y-m-d'), 
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.position-histories-render',[
            'user' => $user
            ])->render();
    }
    public function getPosition(Request $request)
    {
        $userPositions = UserPosition::all();
        $positionHistoryId = $request->data['positionHistoryId'];
        $positionHistory = PositionHistory::find($positionHistoryId);
        return view('groups.user-management-system.setting.userinfo.table-render.update-position-modal-render',[
            'userPositions' => $userPositions,
            'positionHistory' => $positionHistory,
            ])->render();

    }

    public function updatePosition(Request $request)
    {
        $userId = $request->data['userId'];
        $userPositionId = $request->data['position'];
        $positionHistoryId = $request->data['positionHistoryId'];
        $positionAdjustDate = $request->data['positionAdjustDate'];
        PositionHistory::find($positionHistoryId)->update([
            'user_position_id' => $userPositionId,
            'adjust_date' => Carbon::createFromFormat('d/m/Y', $positionAdjustDate)->format('Y-m-d'), 
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.position-histories-render',[
            'user' => $user
            ])->render();
    }

    public function delete(Request $request)
    {
        $userId = $request->data['userId'];
        $positionHistoryId = $request->data['positionHistoryId'];
        PositionHistory::find($positionHistoryId)->delete();
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.position-histories-render',[
            'user' => $user
            ])->render();
    }
}

