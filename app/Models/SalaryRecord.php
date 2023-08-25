<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'salary',
        'record_date'
    ];
}
