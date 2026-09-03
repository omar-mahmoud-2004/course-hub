@extends('layouts.admin')

@section('title', 'لوحة التحكم - الإحصائيات')

@section('content')
<div class="container py-5">

    <!-- رأس الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
        <div>
            <small class="text-primary fw-bold text-uppercase">Admin Panel</small>
            <h1 class="fw-bold mt-1 mb-0">لوحة التحكم الرئيسية</h1>
            <p class="text-secondary fs-6 mb-0">نظرة عامة على نشاط وإحصائيات المنصة التعليمية.</p>
        </div>
    </div>

    <!-- كروت الإحصائيات العامة -->
    <div class="row g-4 mb-5">
        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="text-primary mb-2"><i class="bi bi-people-fill fs-2"></i></div>
                <h6 class="text-muted small fw-semibold">الطلاب</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_students'] }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="text-success mb-2"><i class="bi bi-person-video3 fs-2"></i></div>
                <h6 class="text-muted small fw-semibold">المدرسين</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_teachers'] }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="text-info mb-2"><i class="bi bi-journal-code fs-2"></i></div>
                <h6 class="text-muted small fw-semibold">الكورسات</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_courses'] }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="text-warning mb-2"><i class="bi bi-card-checklist fs-2"></i></div>
                <h6 class="text-muted small fw-semibold">الاشتراكات</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_enrollments'] }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="text-secondary mb-2"><i class="bi bi-tags-fill fs-2"></i></div>
                <h6 class="text-muted small fw-semibold">التصنيفات</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_categories'] }}</h3>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="text-danger mb-2"><i class="bi bi-star-fill fs-2"></i></div>
                <h6 class="text-muted small fw-semibold">التقييمات</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_reviews'] }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- آخر 5 مستخدمين مسجلين -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-person-plus text-primary me-2"></i>آخر المستخدمين الجدد</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>الاسم</th>
                                <th>البريد</th>
                                <th>الرتبة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats['recent_users'] as $user)
                                <tr>
                                    <td class="fw-semibold">{{ $user->name }}</td>
                                    <td class="text-muted small">{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'teacher' ? 'bg-success' : 'bg-primary') }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">لا يوجد مستخدمين بعد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- آخر 5 كورسات مضافة -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-book text-success me-2"></i>آخر الكورسات المضافة</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>اسم الكورس</th>
                                <th>تاريخ الإضافة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats['recent_courses'] as $course)
                                <tr>
                                    <td class="fw-semibold">{{ $course->title ?? $course->name }}</td>
                                    <td class="text-muted small">{{ $course->created_at ? $course->created_at->diffForHumans() : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-3">لا توجد كورسات مضافة بعد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection