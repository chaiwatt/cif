<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationNewAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'application_new_id',
        'file'
    ];
}
