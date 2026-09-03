<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * إلزام تسجيل الدخول لكافة العمليات
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ==========================================
    // Teacher Section
    // ==========================================

    /**
     * لوحة تحكم المدرس
     */
    public function teacherDashboard()
    {
        $teacher = Auth::user();
        $teacherId = $teacher->id;

        // 1. حساب إحصائيات المدرس
        $totalCourses = Course::where('teacher_id', $teacherId)->count();
        $totalStudents = User::where('role', 'student')->count();

        // حساب متوسط التقييم الفعلي من جدول التقييمات بدقة
        $rawAvg = Course::where('teacher_id', $teacherId)
            ->withAvg('reviews', 'rating')
            ->get()
            ->avg('reviews_avg_rating') ?? 0;

        $averageRating = round($rawAvg, 1);

        // 2. جلب كورسات المدرس الحالي فقط مع الأقسام
        $allCourses = Course::with('category')
            ->where('teacher_id', $teacherId)
            ->latest()
            ->get();

        return view('teacher.dashboard', compact(
            'totalCourses',
            'totalStudents',
            'averageRating',
            'allCourses'
        ));
    }

    /**
     * قائمة الطلاب المشتركين في كورسات المدرس
     */
    public function teacherStudents(Request $request)
    {
        $teacherId = Auth::id();

        // 1. جلب كورسات المدرس لقائمة الفلترة
        $coursesList = Course::where('teacher_id', $teacherId)->get();

        // 2. استقبال قيم البحث والفلترة
        $selectedCourse = $request->input('course_id', 'all');
        $search = trim($request->input('search', ''));

        // 3. الاستعلام عن الطلاب المشتركين في كورسات هذا المدرس
        $studentsQuery = User::where('role', 'student')
            ->whereHas('enrolledCourses', function ($query) use ($teacherId, $selectedCourse) {
                $query->where('teacher_id', $teacherId);

                if ($selectedCourse !== 'all' && (int) $selectedCourse > 0) {
                    $query->where('courses.id', $selectedCourse);
                }
            });

        // فلترة بالاسم أو البريد الإلكتروني
        if (!empty($search)) {
            $studentsQuery->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // جلب البيانات مع تحميل علاقة الكورسات مسبقاً (Eager Loading) لتسريع العرض
        $students = $studentsQuery->with('enrolledCourses')->latest()->get();
        $totalStudents = $students->count();

        return view('teacher.students', compact(
            'students',
            'coursesList',
            'selectedCourse',
            'search',
            'totalStudents'
        ));
    }

    // ==========================================
    // Courses CRUD
    // ==========================================

    /**
     * استعراض قائمة الكورسات
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $role = $user->role ?? 'student';

        $pageTitle = "All Courses";
        $pageSubTitle = "Explore all available courses.";

        $query = Course::with(['category', 'teacher']);

        if ($role === 'teacher') {
            $query->where('teacher_id', $user_id);
            $pageTitle = "My Courses";
            $pageSubTitle = "Manage and view all courses created by you.";
        } elseif ($role === 'student' || $role === 'admin') {
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
                $category = Category::find($request->category_id);
                $catName = $category ? $category->name : 'Selected';
                $pageTitle = $catName . " Courses";
                $pageSubTitle = "Explore available courses in this category.";
            }

            if ($role === 'admin' && !$request->filled('category_id')) {
                $pageTitle = "All Courses";
                $pageSubTitle = "Manage all courses on the platform.";
            }
        }

        $courses = $query->orderBy('id', 'desc')->get();

        return view('courses.index', compact(
            'courses',
            'pageTitle',
            'pageSubTitle',
            'role',
            'user_id'
        ));
    }

    /**
     * صفحة إضافة كورس جديد
     */
    public function create()
    {
        $role = Auth::user()->role ?? 'student';
        if ($role !== 'teacher' && $role !== 'admin') {
            abort(403, 'غير مصرح لك بإضافة كورسات.');
        }

        $categories = Category::all();
        $pageTitle = 'Create Course';
        $pageSubTitle = 'Create a new course';

        return view('courses.create', compact('categories', 'pageTitle', 'pageSubTitle'));
    }

    /**
     * حفظ الكورس
     */
    public function store(Request $request)
    {
        $role = Auth::user()->role ?? 'student';
        if ($role !== 'teacher' && $role !== 'admin') {
            abort(403, 'غير مصرح لك بإضافة كورسات.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('upload', 'public');
        }

        $validated['teacher_id'] = Auth::id();

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * عرض تفاصيل كورس معين
     */
public function show(Course $course)
{
    $course->load(['category', 'teacher', 'reviews.student']);
    return view('courses.show', compact('course'));
}
    /**
     * صفحة تعديل الكورس
     */
    public function edit(Course $course)
    {
        $role = Auth::user()->role ?? 'student';

        if ($role !== 'admin' && Auth::id() !== $course->teacher_id) {
            abort(403, 'لا تملك صلاحية تعديل هذا الكورس.');
        }

        $categories = Category::all();
        return view('courses.edit', compact('course', 'categories'));
    }

    /**
     * تحديث الكورس
     */
    public function update(Request $request, Course $course)
    {
        $role = Auth::user()->role ?? 'student';

        if ($role !== 'admin' && Auth::id() !== $course->teacher_id) {
            abort(403, 'لا تملك صلاحية تعديل هذا الكورس.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'created_at'  => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }
            $validated['image'] = $request->file('image')->store('upload', 'public');
        }

        if ($request->filled('created_at')) {
            $validated['created_at'] = $request->created_at;
        }

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * حذف الكورس
     */
    public function destroy(Course $course)
    {
        $role = Auth::user()->role ?? 'student';

        if ($role !== 'admin' && Auth::id() !== $course->teacher_id) {
            abort(403, 'لا تملك صلاحية حذف هذا الكورس.');
        }

        if ($course->image && Storage::disk('public')->exists($course->image)) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
    public function enroll($id)
{
    $course = Course::findOrFail($id);
    $user = auth()->user();

    // التأكد من عدم تكرار التسجيل لنفس الكورس
    if (!$user->enrolledCourses()->where('course_id', $course->id)->exists()) {
        $user->enrolledCourses()->attach($course->id);
    }

    return redirect()->route('student.course', $course->id)->with('success', 'تم الاشتراك في الكورس بنجاح!');
}
}
