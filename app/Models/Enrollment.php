<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * الحقول المسموح بتعبئتها جماعياً
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'course_id',
    ];

    /**
     * الاشتراك ينتمي لطالب معين
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * الاشتراك خاص بكورس معين
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}