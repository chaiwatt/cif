<?php

namespace App\Models;

use App\Models\User;
use App\Models\Bonus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BonusUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bonus_id',
        'cost'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
