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
        'announce_thumbnail',
        'start_date',
        'end_date'
    ];
}
