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
        'approver_one_id',
        'approver_two_id'
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
     * ความสัมพันธ์กับโมเดล User (ผู้ใช้งาน) เป็นผู้อนุมัติคนที่หนึ่ง
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approver_one()
    {
        return $this->belongsTo(User::class, 'approver_one_id');
    }

    /**
     * ความสัมพันธ์กับโมเดล User (ผู้ใช้งาน) เป็นผู้อนุมัติคนที่สอง
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approver_two()
    {
        return $this->belongsTo(User::class, 'approver_two_id');
    }

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
