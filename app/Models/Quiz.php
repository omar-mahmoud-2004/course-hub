<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Quiz extends Model
{
    protected $fillable = [
        'course_id',
        'question',
        'answer',
        'correct_answer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}