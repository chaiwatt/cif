<?php

namespace App\Models;

use App\Models\User;
use App\Models\DocumentType;
use App\Models\CompanyDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approver extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'document_type_id',
        'company_department_id',
        'code',
        'user_id'
    ];
    /**
     * ความสัมพันธ์กับโมเดล CompanyDepartment (บริษัทและแผนก)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company_department()
    {
        return $this->belongsTo(CompanyDepartment::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล DocumentType (ประเภทเอกสาร)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล User (ผู้ใช้งาน) ผ่านตารางกลาง approver_users
     * (ผู้ใช้งานที่มีสิทธิ์ในสายอนุมัติสำหรับผู้อนุมัตินี้)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'approver_users', 'approver_id', 'user_id');
    }

    public function authorizedUsers()
    {
        return $this->belongsToMany(User::class, 'approve_authorities', 'approver_id', 'user_id');
    }

    public function getApproverUserByUserId($userId)
    {
        return ApproverUser::where('approver_id', $this->id)
            ->where('user_id', $userId)
            ->first();
    }

     public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


}
