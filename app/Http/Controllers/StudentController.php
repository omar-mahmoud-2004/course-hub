<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================
    // Student Dashboard
    // =========================
    public function dashboard()
    {
        /** @var \App\Models\User $student */
        $student = Auth::user();

        // جلب الكورسات المسجل بها الطالب حقيقة
        $myCourses = $student->enrolledCourses()->with(['category', 'lessons'])->get();
        $totalCourses = $myCourses->count();

        // حساب الدروس المكتملة وإجمالي الدروس
        $totalLessons = $myCourses->sum(fn($c) => $c->lessons->count());
        $totalCompleted = method_exists($student, 'completedLessons') 
            ? $student->completedLessons()->count() 
            : 0;

        $overallProgress = $totalLessons > 0 
            ? round(($totalCompleted / $totalLessons) * 100) 
            : 0;

        return view('student.dashboard', compact(
            'student',
            'totalCourses',
            'totalCompleted',
            'totalLessons',
            'overallProgress',
            'myCourses'
        ));
    }

    // =========================
    // My Courses
    // =========================
    public function myCourses()
    {
        /** @var \App\Models\User $student */
        $student = Auth::user();
        $myCourses = $student->enrolledCourses()->with(['category', 'teacher'])->get();

        return view('student.my-courses', compact('student', 'myCourses'));
    }

    // =========================
    // Course Details
    // =========================
    public function course($id)
    {
        $course = Course::with(['category', 'lessons' => function($q) {
            $q->orderBy('id', 'asc');
        }])->findOrFail($id);

        $lessons = $course->lessons;

        return view('student.course', compact('course', 'lessons'));
    }

    // =========================
    // Lesson
    // =========================
    public function lesson($id)
    {
        $student = Auth::user();
        $lesson = Lesson::with('course.lessons')->findOrFail($id);

        return view('student.lesson', compact('student', 'lesson'));
    }

    // =========================
    // Progress
    // =========================
    public function progress()
    {
        /** @var \App\Models\User $student */
        $student = Auth::user();
        $myCourses = $student->enrolledCourses()->with('lessons')->get();

        $totalCourses = $myCourses->count();
        $totalLessons = $myCourses->sum(fn($c) => $c->lessons->count());
        $totalCompleted = method_exists($student, 'completedLessons') 
            ? $student->completedLessons()->count() 
            : 0;

        $overallProgress = $totalLessons > 0 
            ? round(($totalCompleted / $totalLessons) * 100) 
            : 0;

        return view('student.progress', compact(
            'student',
            'totalCourses',
            'totalCompleted',
            'totalLessons',
            'overallProgress',
            'myCourses'
        ));
    }

    // =========================
    // Quiz
    // =========================
    public function quiz($id)
    {
        $course = Course::findOrFail($id);
        $questions = Quiz::where('course_id', $id)->orderBy('id', 'asc')->get();

        return view('student.quiz', compact('course', 'questions'));
    }

    // =========================
    // Submit Quiz
    // =========================
    public function submitQuiz(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $questions = Quiz::where('course_id', $id)->orderBy('id', 'asc')->get();

        $score = 0;
        foreach ($questions as $question) {
            $userAnswer = $request->input('answer.' . $question->id);
            if ($userAnswer !== null && strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer))) {
                $score++;
            }
        }

        $total = $questions->count();
        $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;

        return view('student.quiz', compact('course', 'questions', 'score', 'total', 'percentage'));
    }

    // =========================
    // Profile
    // =========================
    public function profile()
    {
        $student = Auth::user();
        return view('student.profile', compact('student'));
    }

    // =========================
    // Update Profile
    // =========================
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $student */
        $student = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $student->id,
            'password' => 'nullable|min:8|confirmed',
            'img'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $student->name = $request->name;
        $student->email = $request->email;

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/users'), $imageName);
            $student->img = $imageName;
        }

        $student->save();

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }
}