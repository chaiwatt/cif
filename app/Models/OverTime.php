<?php

namespace App\Models;

use App\Models\OverTimeDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OverTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'from_date',
        'to_date',
        'start_time',
        'end_time',
        'code',
        'approved_list',
        'type',
    ];

    public function overtimeDetails()
    {
        return $this->hasMany(OverTimeDetail::class);
    }

}
