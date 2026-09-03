<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // التأكد من تسجيل الدخول وأن الحساب أدمن
        if (!$user || $user->role !== 'admin') {
            abort(403, 'غير مصرح لك بدخول لوحة الإدارة.');
        }

        return $next($request);
    }
}