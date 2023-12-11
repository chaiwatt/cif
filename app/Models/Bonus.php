<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bonus extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'issued',
        'description',
        'status'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
