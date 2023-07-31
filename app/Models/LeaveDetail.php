<?php

namespace App\Models;

use App\Models\Leave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'leave_id',
        'from_date',
        'to_date',
        'duration',
    ];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }
}
