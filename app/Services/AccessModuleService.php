<?php
namespace App\Services;

use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Response;

class AccessModuleService
{
    public function hasAccessToModule(User $user, Module $module)
    {
        if (!$module) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $roles = $user->roles()->whereHas('groups', function ($query) use ($module) {
            $query->where('groups.id', $module->id);
        })->get();

        if ($roles->isEmpty()) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}
