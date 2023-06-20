<?php

namespace App\Models;

use App\Models\User;
use App\Models\Group;
use App\Models\RoleGroupJson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    /**
     * ความสัมพันธ์กับโมเดล User (ผู้ใช้งาน) ผ่านตารางกลาง role_users
     * (ผู้ใช้งานที่มีบทบาทนี้)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
    }

    /**
     * ความสัมพันธ์กับโมเดล Group (กลุ่มงาน) ผ่านตารางกลาง group_roles
     * (กลุ่มงานที่มีบทบาทนี้)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_roles', 'role_id', 'group_id');
    }

    /**
     * ความสัมพันธ์กับโมเดล RoleGroupJson ในรูปแบบ One-to-Many
     * (ข้อมูล JSON ของบทบาทกับกลุ่มงานที่มีบทบาทนี้)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function role_group_jsons()
    {
        return $this->hasMany(RoleGroupJson::class);
    }

}
