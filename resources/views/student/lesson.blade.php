@extends('layouts.app')

@section('title', ($lesson->title ?? 'Lesson') . ' - CourseHub')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ route('student.course', $lesson->course_id ?? 1) }}" class="text-decoration-none text-muted fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Back to Course
        </a>
    </div>

    @if($lesson)
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 p-lg-5">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2">{{ $lesson->course->title ?? 'Course' }}</span>
                <h2 class="fw-bold mb-1">{{ $lesson->title }}</h2>
                <p class="text-muted mb-0 small"><i class="bi bi-clock me-1"></i> Duration: {{ $lesson->duration ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-play-btn text-primary me-2"></i>Lesson Video</h5>
                @if(!empty($lesson->video_url))
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                        <iframe src="{{ $lesson->video_url }}" title="{{ $lesson->title }}" allowfullscreen></iframe>
                    </div>
                @else
                    <div class="alert alert-secondary mb-0 rounded-3">
                        <i class="bi bi-camera-video-off me-2"></i> No video available for this lesson.
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm text-center py-5 rounded-4">
            <i class="bi bi-exclamation-circle fs-1 text-muted mb-3"></i>
            <h4 class="fw-bold">Lesson Not Found</h4>
            <p class="text-muted">The requested lesson is currently unavailable.</p>
            <a href="{{ route('student.dashboard') }}" class="btn btn-primary rounded-pill px-4">Back to Dashboard</a>
        </div>
    @endif
</div>
@endsection