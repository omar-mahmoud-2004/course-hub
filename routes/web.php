<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// استيراد الموديلز للصفحة الرئيسية
use App\Models\Course;
use App\Models\Category;
use App\Models\User;

// استيراد متحكمات الموقع العام والمدرس والطلاب
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StudentController;

// استيراد متحكمات الأدمن بأسماء مستعارة منعاً لتضارب الأسماء
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// ==========================================
// الصفحة الرئيسية (بيانات حقيقية من قاعدة البيانات)
// ==========================================
Route::get('/', function () {
    $featuredCourses = Course::with(['category', 'teacher'])->latest()->take(3)->get();
    $topCategories   = Category::withCount('courses')->take(4)->get();
    $totalStudents   = User::where('role', 'student')->count();
    $totalCourses    = Course::count();
    $totalTeachers   = User::where('role', 'teacher')->count();

    return view('welcome', compact(
        'featuredCourses',
        'topCategories',
        'totalStudents',
        'totalCourses',
        'totalTeachers'
    ));
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// ==========================================
// 1. مسارات لوحة تحكم الأدمن (Admin Panel)
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('courses', AdminCourseController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('reviews', AdminReviewController::class);
});

// ==========================================
// 2. مسارات الموقع العام والمدرس والطلاب
// ==========================================
Route::middleware(['auth'])->group(function () {

    // مسارات لوحة تحكم المدرس
    Route::get('/teacher/dashboard', [CourseController::class, 'teacherDashboard'])->name('teacher.dashboard');
    Route::get('/teacher/students', [CourseController::class, 'teacherStudents'])->name('teacher.students');

    // مسارات لوحة تحكم وخدمات الطالب
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/my-courses', [StudentController::class, 'myCourses'])->name('my-courses');
        Route::get('/course/{id}', [StudentController::class, 'course'])->name('course');
        Route::get('/lesson/{id}', [StudentController::class, 'lesson'])->name('lesson');
        Route::get('/progress', [StudentController::class, 'progress'])->name('progress');
        Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
        Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
        Route::get('/quiz/{id}', [StudentController::class, 'quiz'])->name('quiz');
        Route::post('/quiz/{id}', [StudentController::class, 'submitQuiz'])->name('quiz.submit');
    });
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');    
    // مسارات الكورسات والتصنيفات العامة
    Route::resource('courses', CourseController::class);
    Route::resource('categories', CategoryController::class);

    // مسار إدارة الدروس الفعلي
    Route::resource('lessons', LessonController::class);

    // مسار إضافة أو تحديث تقييم الكورس للطلاب
    Route::post('/courses/{course}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});