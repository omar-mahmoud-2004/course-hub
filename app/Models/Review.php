<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * الحقول المسموح بتعبئتها جماعياً
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'student_id',
        'rating',
        'comment',
    ];

    /**
     * التقييم ينتمي لكورس معين
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * التقييم كتبه طالب معين
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}