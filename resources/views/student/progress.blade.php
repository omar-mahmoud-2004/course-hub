@extends('layouts.app')

@section('title', 'Learning Progress - CourseHub')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold">MY PROGRESS</span>
        <h2 class="fw-bold mt-2 mb-1">Learning Progress 📊</h2>
        <p class="text-muted mb-0">Track your learning journey across all courses.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                <span class="text-muted small fw-semibold">My Courses</span>
                <h2 class="fw-bold mb-0 text-primary">{{ number_format($totalCourses ?? 0) }}</h2>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                <span class="text-muted small fw-semibold">Completed Lessons</span>
                <h2 class="fw-bold mb-0 text-success">{{ number_format($totalCompleted ?? 0) }}</h2>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                <span class="text-muted small fw-semibold">Overall Progress</span>
                <h2 class="fw-bold mb-0 text-warning">{{ $overallProgress ?? 0 }}%</h2>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold mb-3">Course Breakdown</h5>
        @if(isset($myCourses) && $myCourses->isNotEmpty())
            @foreach($myCourses as $course)
                <div class="border rounded-3 p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0">{{ $course->title }}</h6>
                        <span class="badge bg-primary-subtle text-primary">{{ $course->lessons->count() }} Lessons</span>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-4 text-muted">
                <p class="mb-0">No active course progress yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection