@extends('layouts.app')

@section('title', 'Create New Lesson - CourseHub')

@section('content')
<style>
    .lesson-form-card {
        background-color: var(--card-bg) !important;
        border: 1px solid var(--border-color) !important;
    }
    .form-control {
        background-color: var(--bg-color) !important;
        color: var(--text-color) !important;
        border: 1px solid var(--border-color) !important;
    }
    .input-group-text {
        background-color: var(--bg-color) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-muted);
    }
    .bg-gradient-blue {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden lesson-form-card">
                <div class="card-header bg-gradient-blue text-white p-4 border-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-file-earmark-play-fill fs-3 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-white">Create Lesson</h4>
                            <p class="mb-0 text-white-50 small">
                                Adding to course: <strong class="text-warning">{{ $course->title }}</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('lessons.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="bi bi-type me-1 text-primary"></i> Lesson Title
                            </label>
                            <input type="text" name="title" class="form-control form-control-lg rounded-3 @error('title') is-invalid @enderror"
                                id="title" placeholder="e.g. Introduction to Controllers" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-card-text me-1 text-primary"></i> Description
                            </label>
                            <textarea name="description" class="form-control rounded-3 @error('description') is-invalid @enderror"
                                id="description" rows="3" placeholder="Enter a brief description of the lesson...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="video_url" class="form-label fw-bold">
                                <i class="bi bi-link-45deg me-1 text-primary"></i> Video URL
                            </label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 rounded-start-3">
                                    <i class="bi bi-youtube text-danger"></i>
                                </span>
                                <input type="url" name="video_url" class="form-control form-control-lg rounded-end-3 border-start-0 @error('video_url') is-invalid @enderror"
                                    id="video_url" placeholder="https://www.youtube.com/watch?v=..." value="{{ old('video_url') }}" required>
                            </div>
                            <small class="text-muted mt-1 d-block">Paste YouTube, Vimeo, or external video link.</small>
                            @error('video_url')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <a href="{{ route('lessons.index', ['course_id' => $course->id]) }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-semibold">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>

                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2 rounded-3 fw-bold shadow-sm">
                                <i class="bi bi-plus-circle me-1"></i> Add Lesson
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection