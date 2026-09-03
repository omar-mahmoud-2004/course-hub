<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * الحقول المسموح بتعبئتها جماعياً
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
        'teacher_id',
        'category_id',
    ];

    /**
     * الكورس ينتمي لمدرس معين
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * الكورس ينتمي لقسم/تصنيف معين
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * الكورس يحتوي على عدة دروس
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * الطلاب المشتركين في الكورس (عن طريق جدول enrollments)
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id')->withTimestamps();
    }

    /**
     * الكورس يحتوي على عدة تقييمات
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    
}