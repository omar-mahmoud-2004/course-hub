@extends('layouts.app')

@section('title', 'Student Dashboard - CourseHub')

@section('content')
<div class="container py-4">
    <!-- Welcome Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4">
        <div>
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2 fw-semibold">STUDENT PANEL</span>
            <h1 class="fw-bold mb-2">Welcome back, {{ $student->name ?? auth()->user()->name }}! 👋</h1>
            <p class="text-muted mb-4">Continue your learning journey and explore new courses.</p>
            <a href="{{ route('courses.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                <i class="bi bi-compass me-1"></i> Explore Courses
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="rounded-3 bg-primary-subtle text-primary d-inline-flex p-3 fs-3 mb-3 w-auto align-self-start">
                    <i class="bi bi-book"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $totalCourses ?? 0 }}</h3>
                <span class="text-muted small">My Courses</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="rounded-3 bg-success-subtle text-success d-inline-flex p-3 fs-3 mb-3 w-auto align-self-start">
                    <i class="bi bi-check-circle"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $totalCompleted ?? 0 }}</h3>
                <span class="text-muted small">Completed Lessons</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="rounded-3 bg-warning-subtle text-warning d-inline-flex p-3 fs-3 mb-3 w-auto align-self-start">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $overallProgress ?? $progress ?? 0 }}%</h3>
                <span class="text-muted small">Overall Progress</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h5 class="fw-bold mb-3">Quick Actions</h5>
        <div class="row g-2">
            <div class="col-6 col-md-3">
                <a href="{{ route('student.my-courses') }}" class="btn btn-outline-primary w-100 py-2 rounded-3 fw-semibold small">
                    <i class="bi bi-collection-play me-1"></i> My Courses
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('student.progress') }}" class="btn btn-outline-success w-100 py-2 rounded-3 fw-semibold small">
                    <i class="bi bi-pie-chart me-1"></i> My Progress
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('student.progress') }}" class="btn btn-outline-warning w-100 py-2 rounded-3 fw-semibold small">
                    <i class="bi bi-question-circle me-1"></i> Quizzes
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('student.profile') }}" class="btn btn-outline-secondary w-100 py-2 rounded-3 fw-semibold small">
                    <i class="bi bi-person me-1"></i> Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Enrolled Courses -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">My Enrolled Courses</h5>
            <a href="{{ route('student.my-courses') }}" class="small text-decoration-none">View All</a>
        </div>

        @if(isset($myCourses) && $myCourses->count() > 0)
            <div class="row g-3">
                @foreach($myCourses as $course)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border rounded-3 overflow-hidden">
                            @if(!empty($course->image))
                                <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" style="height: 160px; object-fit: cover;" alt="{{ $course->title }}">
                            @endif
                            <div class="card-body d-flex flex-column justify-content-between p-3">
                                <div>
                                    <span class="badge bg-light text-dark border mb-2">{{ $course->category->name ?? 'Course' }}</span>
                                    <h6 class="fw-bold mb-2">{{ $course->title }}</h6>
                                </div>
                                <a href="{{ route('student.course', $course->id) }}" class="btn btn-sm btn-primary rounded-pill mt-3">Continue Learning</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-journal-x fs-1 opacity-50 d-block mb-2"></i>
                <p class="mb-3">You haven't enrolled in any courses yet.</p>
                <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">Explore Courses</a>
            </div>
        @endif
    </div>
</div>
@endsection