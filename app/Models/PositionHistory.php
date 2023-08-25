<?php

namespace App\Models;

use App\Models\UserPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PositionHistory extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'user_position_id',
        'adjust_date'
    ];

    public function user_position()
    {
        return $this->belongsTo(UserPosition::class);
    }
}