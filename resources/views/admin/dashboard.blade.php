@extends('layouts.admin')

@section('content')
<div class="container py-5">

    <!-- العنوان والتنقل العلوي -->
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
        <div>
            <small class="text-primary fw-bold text-uppercase tracking-wider">ADMIN PANEL</small>
            <h1 class="fw-bold mt-1 mb-1 display-6">Dashboard Overview</h1>
            <p class="text-secondary fs-6 mb-0">Manage platform users, courses, categories and reviews.</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.dashboard') }}" class="btn {{ request()->routeIs('admin.dashboard') ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="bi bi-speedometer2 me-1"></i> Dashboard
    </a>
    
    <a href="{{ route('admin.users.index') }}" class="btn {{ request()->routeIs('admin.users.*') ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="bi bi-people me-1"></i> Users
    </a>
    
    <a href="{{ route('admin.courses.index') }}" class="btn {{ request()->routeIs('admin.courses.*') ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="bi bi-book me-1"></i> Courses
    </a>
    
    <a href="{{ route('admin.categories.index') }}" class="btn {{ request()->routeIs('admin.categories.*') ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="bi bi-tags me-1"></i> Categories
    </a>
    
    <a href="{{ route('admin.reviews.index') }}" class="btn {{ request()->routeIs('admin.reviews.*') ? 'btn-primary' : 'btn-outline-primary' }}">
        <i class="bi bi-star me-1"></i> Reviews
    </a>
</div>
    </div>

    <!-- كروت الإحصائيات (Stat Cards) -->
    <div class="row g-4 mb-5">
        <!-- Students -->
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary fw-semibold">Students</span>
                        <h1 class="fw-bold mb-0 text-primary mt-2">{{ $total_students }}</h1>
                    </div>
                    <div class="icon-circle bg-primary-subtle text-primary">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary fw-semibold">Teachers</span>
                        <h1 class="fw-bold mb-0 text-success mt-2">{{ $total_teachers }}</h1>
                    </div>
                    <div class="icon-circle bg-success-subtle text-success">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Courses -->
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary fw-semibold">Total Courses</span>
                        <h1 class="fw-bold mb-0 text-info mt-2">{{ $total_courses }}</h1>
                    </div>
                    <div class="icon-circle bg-info-subtle text-info">
                        <i class="bi bi-journal-code"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrollments -->
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary fw-semibold">Enrollments</span>
                        <h1 class="fw-bold mb-0 text-warning mt-2">{{ $total_enrollments }}</h1>
                    </div>
                    <div class="icon-circle bg-warning-subtle text-warning">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary fw-semibold">Categories</span>
                        <h1 class="fw-bold mb-0 text-secondary mt-2">{{ $total_categories }}</h1>
                    </div>
                    <div class="icon-circle bg-secondary-subtle text-secondary">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews -->
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary fw-semibold">Reviews</span>
                        <h1 class="fw-bold mb-0 text-danger mt-2">{{ $total_reviews }}</h1>
                    </div>
                    <div class="icon-circle bg-danger-subtle text-danger">
                        <i class="bi bi-star-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- جداول آخر النشاطات -->
    <div class="row g-4">
        <!-- Recent Users -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Recent Users</h5>
                    <a href="{{ route('admin.users.index') }}" class="text-decoration-none small fw-semibold text-primary">View All &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Name</th>
                                <th class="border-0">Email</th>
                                <th class="border-0">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recent_users as $user)
                                <tr>
                                    <td class="fw-semibold text-dark">{{ $user->name }}</td>
                                    <td><span class="text-secondary small">{{ $user->email }}</span></td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'teacher' ? 'bg-success' : 'bg-primary') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Courses -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i>Recent Courses</h5>
                    <a href="{{ route('admin.courses.index') }}" class="text-decoration-none small fw-semibold text-primary">View All &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Course</th>
                                <th class="border-0">Instructor</th>
                                <th class="border-0">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recent_courses as $course)
                                <tr>
                                    <td class="fw-semibold text-dark">{{ $course->title ?? $course->name }}</td>
                                    <td>
                                        <span class="text-secondary small">{{ $course->teacher->name ?? $course->teacher_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-success fw-bold">${{ number_format($course->price ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No courses found.</td>
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