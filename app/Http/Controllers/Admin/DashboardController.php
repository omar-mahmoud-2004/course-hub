<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Review;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        $total_students    = User::where('role', 'student')->count();
        $total_teachers    = User::where('role', 'teacher')->count();
        $total_courses     = Course::count();
        $total_enrollments = class_exists(Enrollment::class) ? Enrollment::count() : 0;
        $total_categories  = Category::count();
        $total_reviews     = class_exists(Review::class) ? Review::count() : 0;

        $recent_users   = User::latest()->take(5)->get();
        $recent_courses = Course::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'total_students',
            'total_teachers',
            'total_courses',
            'total_enrollments',
            'total_categories',
            'total_reviews',
            'recent_users',
            'recent_courses'
        ));
    }
}