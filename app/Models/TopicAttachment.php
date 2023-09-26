<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'topic_id',
        'file'
    ];
}
