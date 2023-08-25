<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course',
        'organizer',
        'year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
