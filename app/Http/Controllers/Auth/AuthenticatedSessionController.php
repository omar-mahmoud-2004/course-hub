<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * معالجة طلب تسجيل الدخول
     */
    public function store(Request $request)
    {
        // 1. التحقق من صحة البيانات المدخلة
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. محاولة تسجيل الدخول
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // إعادة إنشاء الجلسة للحماية من Session Fixation
            $request->session()->regenerate();

            $user = Auth::user();

            // 3. التوجيه بناءً على دور المستخدم (Role)
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'teacher') {
                return redirect()->intended(route('teacher.dashboard'));
            }

            // للمستخدمين العاديين/الطلاب
            return redirect()->intended('/');
        }

        // 4. في حالة خطأ في البيانات (الإيميل أو كلمة المرور)
        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة، يرجى التأكد وإعادة المحاولة.',
        ])->onlyInput('email');
    }

    /**
     * تسجيل الخروج
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
