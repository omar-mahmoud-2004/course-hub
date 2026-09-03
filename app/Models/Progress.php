<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    // لارافيل افتراضياً يجمع اسم الجدول إلى progresses
    // نحدد اسم الجدول صراحة هنا لأن اسمه في المايجريشن progress
    protected $table = 'progress';

    /**
     * الحقول المسموح بتعبئتها جماعياً
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'lesson_id',
        'completed_at',
    ];

    /**
     * السجل ينتمي لطالب معين
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * السجل ينتمي لدرس معين
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}