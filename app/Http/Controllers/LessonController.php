<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * عرض دروس كورس معين
     */
    public function index(Request $request)
    {
        $courseId = $request->get('course_id');
        $course = null;

        if ($courseId) {
            $course = Course::findOrFail($courseId);
            $lessons = $course->lessons()->latest()->get();
        } else {
            $lessons = Lesson::with('course')->latest()->get();
        }

        return view('lessons.index', compact('lessons', 'course'));
    }

    /**
     * صفحة إضافة درس جديد لكورس محدد
     */
    public function create(Request $request)
    {
        $courseId = $request->get('course_id');

        if (!$courseId) {
            return redirect()->route('courses.index')->with('error', 'Please select a course first.');
        }

        $course = Course::findOrFail($courseId);

        // حماية: لا يضيف الدرس إلا صاحب الكورس أو الأدمن
        if (Auth::user()->role !== 'admin' && Auth::id() !== $course->teacher_id) {
            abort(403, 'Unauthorized access.');
        }

        return view('lessons.create', compact('course'));
    }

    /**
     * حفظ الدرس في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'required|url',
        ]);

        $course = Course::findOrFail($validated['course_id']);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $course->teacher_id) {
            abort(403, 'Unauthorized access.');
        }

        Lesson::create($validated);

        return redirect()->route('lessons.index', ['course_id' => $course->id])
            ->with('success', 'Lesson added successfully.');
    }

    /**
     * صفحة تعديل الدرس
     */
    public function edit(Lesson $lesson)
    {
        $course = $lesson->course;

        if (Auth::user()->role !== 'admin' && Auth::id() !== $course->teacher_id) {
            abort(403, 'Unauthorized access.');
        }

        return view('lessons.edit', compact('lesson', 'course'));
    }

    /**
     * تحديث بيانات الدرس
     */
    public function update(Request $request, Lesson $lesson)
    {
        $course = $lesson->course;

        if (Auth::user()->role !== 'admin' && Auth::id() !== $course->teacher_id) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'required|url',
        ]);

        $lesson->update($validated);

        return redirect()->route('lessons.index', ['course_id' => $course->id])
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * حذف الدرس
     */
    public function destroy(Lesson $lesson)
    {
        $course = $lesson->course;

        if (Auth::user()->role !== 'admin' && Auth::id() !== $course->teacher_id) {
            abort(403, 'Unauthorized access.');
        }

        $courseId = $lesson->course_id;
        $lesson->delete();

        return redirect()->route('lessons.index', ['course_id' => $courseId])
            ->with('success', 'Lesson deleted successfully.');
    }
}