<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * إلزام تسجيل الدخول لجميع العمليات
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * عرض جميع التصنيفات للجميع مع عدد الكورسات
     */
    public function index()
    {
        // جلب التصنيفات مع عدد الكورسات الخاصة بكل قسم دفعة واحدة
        $categories = Category::withCount('courses')->latest()->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * صفحة إضافة تصنيف جديد (للأدمن فقط)
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بإضافة تصنيفات جديدة.');
        }

        return view('categories.create');
    }

    /**
     * حفظ التصنيف الجديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بإضافة تصنيفات.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // رفع الأيقونة إذا وُجدت
        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'تم إنشاء التصنيف بنجاح.');
    }

    /**
     * صفحة تعديل التصنيف (للأدمن فقط)
     */
    public function edit(Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بتعديل هذا التصنيف.');
        }

        return view('categories.edit', compact('category'));
    }

    /**
     * تحديث بيانات التصنيف
     */
    public function update(Request $request, Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بتعديل هذا التصنيف.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // إذا رُفعت أيقونة جديدة، احذف القديمة أولاً
        if ($request->hasFile('icon')) {
            if ($category->icon && Storage::disk('public')->exists($category->icon)) {
                Storage::disk('public')->delete($category->icon);
            }
            $validated['icon'] = $request->file('icon')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح.');
    }

    /**
     * حذف التصنيف مع أيقونته
     */
    public function destroy(Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بحذف التصنيفات.');
        }

        // حذف ملف الأيقونة من القرص إن وجد
        if ($category->icon && Storage::disk('public')->exists($category->icon)) {
            Storage::disk('public')->delete($category->icon);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'تم حذف التصنيف بنجاح.');
    }
}