@extends('layouts.app')

@section('title', 'Lessons List - CourseHub')

@section('content')
<style>
    .lessons-card {
        background-color: var(--card-bg) !important;
        border: 1px solid var(--border-color) !important;
    }
    .table {
        --bs-table-bg: transparent;
        --bs-table-color: var(--text-color);
        border-color: var(--border-color);
    }
    .table thead th {
        background-color: var(--bg-color);
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
    }
    .table tbody td {
        color: var(--text-color);
        border-bottom: 1px solid var(--border-color);
    }
    .bg-gradient-blue {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }
    .fs-7 { font-size: 0.75rem; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-between" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                        <span class="fw-semibold">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden lessons-card">
                <div class="card-header bg-gradient-blue text-white p-4 border-0 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-collection-play-fill fs-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white">Lessons List</h4>
                            @if(isset($course))
                                <p class="mb-0 text-white-50 small">
                                    Course: <span class="text-warning fw-semibold">{{ $course->title }}</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    @if(isset($course))
                        <a href="{{ route('lessons.create', ['course_id' => $course->id]) }}" class="btn btn-light text-primary fw-bold px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-plus-circle-fill fs-5 text-primary"></i>
                            <span>Add New Lesson</span>
                        </a>
                    @else
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-light px-4 py-2 rounded-3 fw-semibold">
                            <i class="bi bi-arrow-left me-1"></i> Select a Course First
                        </a>
                    @endif
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="py-3 ps-4 text-uppercase fs-7 fw-bold" style="width: 8%;">#</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold" style="width: 42%;">Lesson Title</th>
                                    <th class="py-3 text-center text-uppercase fs-7 fw-bold" style="width: 25%;">Video Link</th>
                                    <th class="py-3 text-center text-uppercase fs-7 fw-bold" style="width: 25%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lessons as $key => $lesson)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold rounded-circle p-2" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                {{ $key + 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold fs-6">{{ $lesson->title }}</div>
                                            @if($lesson->description)
                                                <small class="text-muted">{{ Str::limit($lesson->description, 60) }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(!empty($lesson->video_url))
                                                <a href="{{ $lesson->video_url }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-3 px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-youtube"></i> Watch Video
                                                </a>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill fw-normal">No Video</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex align-items-center gap-2">
                                                <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3 fw-semibold d-flex align-items-center gap-1 shadow-sm">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>

                                                <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3 fw-semibold d-flex align-items-center gap-1 shadow-sm" onclick="return confirm('Are you sure you want to delete this lesson?')">
                                                        <i class="bi bi-trash-fill"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="bi bi-journal-x display-4 text-primary opacity-50 d-block mb-3"></i>
                                                <h6 class="fw-bold text-secondary mb-1">No lessons found</h6>
                                                <p class="text-muted small mb-0">Start by adding a new lesson to this course.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection