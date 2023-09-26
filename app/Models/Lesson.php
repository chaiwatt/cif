<?php

namespace App\Models;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];
    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'lesson_id');
    }
}
