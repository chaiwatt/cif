<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationNew extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'status',
        // Add new fillable
        'amount_apply',
        'start_date',
        'end_date',
        'application_form'
    ];
}

