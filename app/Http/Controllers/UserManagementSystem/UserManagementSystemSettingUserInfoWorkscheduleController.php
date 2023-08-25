<?php

namespace App\Http\Controllers\UserManagementSystem;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\Payday;
use App\Models\Approver;
use App\Models\ApproverUser;
use Illuminate\Http\Request;
use App\Models\OverTimeDetail;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignment;

class UserManagementSystemSettingUserInfoWorkscheduleController extends Controller
{
    public function updateWorkschedule(Request $request)
    {
        $userId = $request->data['userId'];
        $workScheduleId = $request->data['workScheduleId'];
        $selectedMonths = $request->data['selectedMonths'];

        $user = User::find($userId);
        $year = Carbon::now()->year;
        foreach ($selectedMonths as $month)
        {
                $workScheduleAssignments = WorkScheduleAssignment::where('work_schedule_id', $workScheduleId)
                    ->where('month_id', $month)
                    ->where('year', $year)
                    ->get();
                // ลบการกำหนดงานใน WorkScheduleAssignment ของผู้ใช้นั้น
                $user->detachWorkScheduleAssignments($workScheduleId, $month, $year);
                // กำหนดการกำหนดงานใหม่ใน WorkScheduleAssignment ของผู้ใช้นั้น
                $user->attachWorkScheduleAssignments($workScheduleAssignments);
        }
        return;
    }

    public function updatePayday(Request $request)
    {
        $userId = $request->data['userId'];
        $selectedPaydayIds = $request->data['selectedPaydayIds'];
        $user = User::find($userId);

        // Detach existing paydays that are not in selectedPaydayIds
        $existingPaydayIds = $user->paydays->pluck('id')->toArray();
        $paydaysToDetach = array_diff($existingPaydayIds, $selectedPaydayIds);
        $user->paydays()->detach($paydaysToDetach);

        // Attach selected paydays
        foreach ($selectedPaydayIds as $selectedPaydayId) {
            $user->paydays()->syncWithoutDetaching($selectedPaydayId);
        }

        return;
    }

    public function getApprover(Request $request)
    {
        $approverId = $request->data['approverId'];
        $approver = Approver::find($approverId);
        $authorizedUsers = $approver->authorizedUsers;
        return response()->json($authorizedUsers);
    }

    public function updateApprover(Request $request)
    {
        $userId = $request->data['userId'];
        $approverId = $request->data['approverId'];

        $approver = Approver::find($approverId);
        $authorizedUserIds = $approver->authorizedUsers->pluck('id')->toArray();

        $approverUsers = ApproverUser::all();
        $existingUser = ApproverUser::where('user_id', $userId)
                ->whereHas('approver', function ($query) use ($approver) {
                    $query->where('document_type_id', $approver->document_type_id);
                })
                ->first();
        if (!$existingUser) {
            $approver->users()->attach($userId);
        } else {
            $existApprover = Approver::find($existingUser->approver_id); 
            if ($existApprover->document_type_id === $approver->document_type_id) {
                $existApprover->users()->detach($userId);
            } 
            $approver->users()->attach($userId);
        }


        if ($approver->document_type_id == '1')
        {
            $leaves = Leave::all();
            $approverUsers = ApproverUser::where('approver_id',$approverId)->get();
            
            if (!$leaves->isEmpty()) {
                $leaveUserIds = $leaves->pluck('user_id')->toArray();
                $approverUserIds = $approverUsers->pluck('user_id')->toArray();

                $usersToUpdates = array_intersect($leaveUserIds, $approverUserIds);
                // dd($usersToUpdates);
                foreach ($usersToUpdates as $usersToUpdate) {
                    $currentLeave = Leave::where('user_id', $usersToUpdate)->first();
                    if ($currentLeave) {
                        $currentApprovedList = json_decode($currentLeave->approved_list, true);

                        // Remove entries not in $authorizedUserIds
                        $currentApprovedList = array_filter($currentApprovedList, function ($entry) use ($authorizedUserIds) {
                            return in_array($entry['user_id'], $authorizedUserIds);
                        });

                        // Add missing entries from $authorizedUserIds
                        foreach ($authorizedUserIds as $authorizedUserId) {
                            $found = false;
                            foreach ($currentApprovedList as $entry) {
                                if ($entry['user_id'] == $authorizedUserId) {
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $currentApprovedList[] = ['user_id' => $authorizedUserId, 'status' => 0];
                            }
                        }

                        // Update the approved_list field
                        $currentLeave->update([
                            'approved_list' => json_encode($currentApprovedList)
                        ]);
                    }
                }
            }
        }else if($approver->document_type_id == '2')
        {
            $overtimeDetails = OverTimeDetail::all();
            $approverUsers = ApproverUser::where('approver_id',$approverId)->get();
            if (!$overtimeDetails->isEmpty()) {
                $overtimeDetailUserIds = $overtimeDetails->pluck('user_id')->toArray();
                $approverUserIds = $approverUsers->pluck('user_id')->toArray();

                $usersToUpdates = array_intersect($overtimeDetailUserIds, $approverUserIds);

                foreach ($usersToUpdates as $usersToUpdate) {
                    $currentOvertimeDetail = OverTimeDetail::where('user_id', $usersToUpdate)->first();
                    if ($currentOvertimeDetail) {
                        $currentApprovedList = json_decode($currentOvertimeDetail->approved_list, true);

                        $currentApprovedList = array_filter($currentApprovedList, function ($entry) use ($authorizedUserIds) {
                            return in_array($entry['user_id'], $authorizedUserIds);
                        });

                        foreach ($authorizedUserIds as $authorizedUserId) {
                            $found = false;
                            foreach ($currentApprovedList as $entry) {
                                if ($entry['user_id'] == $authorizedUserId) {
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $currentApprovedList[] = ['user_id' => $authorizedUserId, 'status' => 0];
                            }
                        }
                        // Update the approved_list field
                        $currentOvertimeDetail->update([
                            'approved_list' => json_encode($currentApprovedList)
                        ]);
                    }

                }
            }

        }

        return ;
    }



}


