<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $fillable = [
        'thumbnail',
        'title',
        'description',
        'body',
        'status',
        'start_date',
        'end_date'
    ];
}
