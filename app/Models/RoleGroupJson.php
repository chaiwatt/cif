<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleGroupJson extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id',
        'group_id',
        'json',
    ];
    /**
     * ความสัมพันธ์กับโมเดล Group (กลุ่มงาน) ผ่านการสร้างความสัมพันธ์ของคีย์นอกส์ group_id
     * (กลุ่มงานที่เป็นเจ้าของบทบาทนี้)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * ความสัมพันธ์กับโมเดล Role (บทบาท) ผ่านการสร้างความสัมพันธ์ของคีย์นอกส์ role_id
     * (บทบาทที่เป็นของกลุ่มงานนี้)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
