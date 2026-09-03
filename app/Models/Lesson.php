<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'video_url',
        'duration',
        'description',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function completedStudents()
    {
        return $this->belongsToMany(User::class, 'progress', 'lesson_id', 'user_id')->withTimestamps();
    }
}
