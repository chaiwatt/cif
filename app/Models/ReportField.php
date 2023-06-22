<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportField extends Model
{
    use HasFactory;
    protected $fillable = [
        'table',
        'field',
        'type',
        'comment',
        'status'
    ];
}
