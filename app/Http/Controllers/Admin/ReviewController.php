<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * عرض جميع التقييمات مع فلترة النجوم والبحث
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'course']);

        // فلترة بعدد النجوم (1 إلى 5)
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // بحث في نص التعليق
        if ($request->filled('search')) {
            $query->where('comment', 'like', '%' . $request->search . '%');
        }

        $reviews = $query->latest()->paginate(10)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * حذف تقييم مسيء أو غير لائق
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'تم حذف التقييم بنجاح.');
    }
}