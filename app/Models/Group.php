<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    /**
     * ความสัมพันธ์กับโมเดล Role (บทบาท) ผ่านตารางกลาง group_roles
     * (บทบาทที่เกี่ยวข้องกับกลุ่มงานนี้)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'group_roles', 'group_id', 'role_id');
    }

    /**
     * ความสัมพันธ์กับโมเดล Module (โมดูล) ผ่านตารางกลาง module_groups
     * (โมดูลที่เกี่ยวข้องกับกลุ่มงานนี้)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_groups', 'group_id', 'module_id');
    }

}
