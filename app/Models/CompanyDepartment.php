<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyDepartment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'eng_name',
        'code',
    ];
    /**
     * ความสัมพันธ์กับโมเดล User (ผู้ใช้งาน) ผ่านตารางกลาง approver_users
     * (ผู้ใช้งานที่มีสิทธิ์ในการอนุมัติสำหรับผู้อนุมัตินี้)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'approver_users', 'approver_id', 'user_id');
    }

}
