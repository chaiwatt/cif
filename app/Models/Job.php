<?php

namespace App\Models;

use App\Models\Module;
use App\Models\GroupModuleJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    /**
     * ความสัมพันธ์กับโมเดล Module (โมดูล) ผ่านคีย์ต่างประเภท (Foreign Key)
     * เพื่อระบุว่าโมดูลนี้เป็นของกลุ่มงานนี้
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * ความสัมพันธ์กับโมเดล GroupModuleJob (งานของโมดูลในกลุ่มงาน)
     * ผ่านคีย์หนึ่งต่อหนึ่ง (One-to-One)
     * เพื่อระบุว่ากลุ่มงานนี้มีงานเฉพาะสำหรับโมดูลนี้
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group_module_job()
    {
        return $this->hasOne(GroupModuleJob::class);
    }

}
