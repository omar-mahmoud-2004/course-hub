<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * الحقول المسموح بتعبئتها جماعياً
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
    ];

    /**
     * الحقول المخفية من Serialization
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تحويل الحقول
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // العلاقات (Relationships)
    // ==========================================

    // علاقة: المدرس عنده عدة كورسات
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    // علاقة: الطالب مشترك في عدة كورسات (جدول enrollments)
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')->withTimestamps();
    }

    // علاقة: الطالب عنده تقييمات كتبها
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    // علاقة: الطالب عنده دروس أتمّها (جدول progress)
    public function completedLessons()
    {
        return $this->belongsToMany(Lesson::class, 'progress', 'user_id', 'lesson_id')->withTimestamps();
    }
}