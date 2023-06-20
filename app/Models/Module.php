<?php

namespace App\Models;

use App\Models\Job;
use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;
    /**
     * ความสัมพันธ์กับโมเดล Group (กลุ่มงาน) ผ่านตารางกลาง module_groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'module_groups', 'module_id', 'group_id');
    }

    /**
     * ความสัมพันธ์กับโมเดล Job (งาน) ผ่านตารางกลาง job_modules
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_modules', 'module_id', 'job_id');
    }


}
