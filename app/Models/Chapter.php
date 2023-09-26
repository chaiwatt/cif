<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'lesson_id'
    ];
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
    public function topics()
    {
        return $this->hasMany(Topic::class, 'chapter_id');
    }
}
