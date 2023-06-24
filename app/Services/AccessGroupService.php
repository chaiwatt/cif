<?php

namespace App\Services;

use App\Models\User;
use App\Models\Group;
use App\Models\RoleGroupJson;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class AccessGroupService
{
    public function hasAccess(User $user, Group $group)
    {

        if (!$group) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $role = $user->roles()->first();
        if ($role == null) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $roleGroupJson = RoleGroupJson::where('group_id',$group->id)->where('role_id',$user->roles()->first()->id)->get();
        if ($roleGroupJson->count() == 0) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }

    public function hasPermission(Collection $updatedRoleGroupCollection, $module, $workingJob,$action)
    {
        $workingModule = $updatedRoleGroupCollection->where('module_name', $module->name);
        $permission = $workingModule->first()->jobs->where('job_name', $workingJob->name)->first()->permissions;

        foreach ($permission as $key => $value) {
            $permission->$key = self::convertStringToBoolean($value);
        }

        $check = $permission->$action ?? null;
        if(!$check)
        {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $permission;
    }

    public static function convertStringToBoolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
 
}
