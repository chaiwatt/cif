<?php

namespace App\Models;

use App\Models\User;
use App\Models\PaydayDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payday extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cross_month',
        'start_day',
        'end_day',
        'payment_type',
        'duration',
        'year',
        'first_payday_id',
        'second_payday_id',
        'type'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_paydays', 'payday_id', 'user_id');
    }

    public function paydayDetails()
    {
        return $this->hasMany(PaydayDetail::class);
    }
}
