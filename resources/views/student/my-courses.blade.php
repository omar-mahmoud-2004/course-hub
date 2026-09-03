@extends('layouts.app')

@section('title', 'My Courses - CourseHub')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold">MY LEARNING</span>
        <h2 class="fw-bold mt-2 mb-1">My Courses 📚</h2>
        <p class="text-muted mb-0">Courses you are currently enrolled in.</p>
    </div>

    <div class="row g-4">
        @if($myCourses->count() > 0)
            @foreach($myCourses as $course)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        @if(!empty($course->image))
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" style="width:100%; height:180px; object-fit:cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-body-tertiary" style="height:180px;">
                                <i class="bi bi-journal-richtext fs-1 text-muted"></i>
                            </div>
                        @endif

                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 mb-2">{{ $course->category->name ?? 'General' }}</span>
                                <h5 class="fw-bold mb-2">{{ $course->title }}</h5>
                                <p class="text-muted small mb-3">{{ Str::limit($course->description ?? '', 90) }}</p>
                            </div>
                            <div>
                                <a href="{{ route('student.course', $course->id) }}" class="btn btn-primary w-100 rounded-pill fw-semibold">
                                    <i class="bi bi-play-circle me-1"></i> Continue Learning
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5 rounded-4">
                    <i class="bi bi-journal-x fs-1 text-muted opacity-50 mb-3"></i>
                    <h4 class="fw-bold">No Courses Yet</h4>
                    <p class="text-muted mb-4">You haven't enrolled in any course yet.</p>
                    <div>
                        <a href="{{ route('courses.index') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-compass me-1"></i> Explore Courses
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection