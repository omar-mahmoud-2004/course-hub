<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * حفظ أو تحديث تقييم الطالب للكورس
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // منع المدرس من تقييم الكورس الخاص به
        if ($course->teacher_id === Auth::id()) {
            return back()->with('error', 'You cannot review your own course.');
        }

        // استخدام updateOrCreate لضمان وجود تقييم واحد فقط لكل طالب على الكورس
        Review::updateOrCreate(
            [
                'course_id'  => $course->id,
                'student_id' => Auth::id(),
            ],
            [
                'rating'  => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Your review has been submitted successfully! ⭐');
    }
}