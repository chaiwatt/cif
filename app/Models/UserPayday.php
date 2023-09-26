<?php

namespace App\Models;

use App\Models\User;
use App\Models\Payday;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPayday extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_paydays', 'payday_id', 'user_id');
    }
    public function payday()
    {
        return $this->belongsTo(Payday::class);
    }
}
