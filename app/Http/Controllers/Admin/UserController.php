<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * عرض قائمة المستخدمين مع فلترة اختيارية بحسب الرتبة
     */
    public function index(Request $request)
    {
        // استعلام لجلب المستخدمين مع إمكانية فلترة الرتبة لو اختارها الأدمن
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        // إحصائيات سريعة للرؤوس العلوية
        $rolesCount = [
            'all'      => User::count(),
            'admins'   => User::where('role', 'admin')->count(),
            'teachers' => User::where('role', 'teacher')->count(),
            'students' => User::where('role', 'student')->count(),
        ];

        return view('admin.users.index', compact('users', 'rolesCount'));
    }

    /**
     * تحديث رتبة المستخدم (Role)
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:admin,teacher,student',
        ]);

        // حماية: منع الأدمن من سحب صلاحية الأدمن من حسابه الحالي حتى لا يقفل على نفسه
        if (auth()->id() == $user->id && $request->role !== 'admin') {
            return back()->with('error', 'لا يمكنك إزالة صلاحية الأدمن من حسابك الحالي.');
        }

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث رتبة المستخدم بنجاح.');
    }

    /**
     * حذف مستخدم من المنصة
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // حماية: لا يمكن للأدمن حذف نفسه
        if (auth()->id() == $user->id) {
            return back()->with('error', 'لا يمكنك حذف حسابك الشخصي المسجل به حالياً!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}