<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * عرض كل الكورسات مع الفلترة والبحث
     */
    public function index(Request $request)
    {
        $query = Course::with(['category', 'teacher'])->withCount('reviews');

        // فلترة بحسب التصنيف
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // بحث باسم الكورس
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $courses = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    /**
     * حذف كورس من المنصة
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'تم حذف الكورس بنجاح.');
    }
}