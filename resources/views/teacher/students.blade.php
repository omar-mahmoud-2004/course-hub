@extends('layouts.app')

@section('title', 'Enrolled Students - CourseHub')

@section('content')
<style>
    .teacher-students-page {
        background-color: var(--bg-color);
        min-height: 85vh;
        transition: background-color 0.3s ease;
    }

    .students-card {
        background-color: var(--card-bg) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 16px;
    }

    .search-input-group .input-group-text {
        background-color: var(--bg-color) !important;
        border: 1px solid var(--border-color) !important;
        border-right: none !important;
        color: var(--text-muted);
    }

    .search-input-group .form-control {
        border-left: none !important;
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
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table tbody td {
        color: var(--text-color);
        border-bottom: 1px solid var(--border-color);
    }
</style>

<div class="teacher-students-page py-4">
    <div class="container-fluid px-4 px-lg-5">

        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1">Enrolled Students</h2>
                <p class="text-muted mb-0">Track and monitor student progress across all your courses.</p>
            </div>
            <div>
                <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2 rounded-pill border border-primary-subtle">
                    <i class="fa-solid fa-users me-1"></i> Total Students: {{ number_format($totalStudents) }}
                </span>
            </div>
        </div>

        <!-- Filter & Search Bar Card -->
        <div class="card p-3 mb-4 students-card">
            <form action="{{ route('teacher.students') }}" method="GET" class="row g-3 align-items-center">

                <!-- Search Input -->
                <div class="col-md-5 col-lg-6">
                    <div class="input-group search-input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" class="form-control shadow-none"
                            placeholder="Search student by name or email...">
                    </div>
                </div>

                <!-- Course Filter -->
                <div class="col-md-5 col-lg-4">
                    <select name="course_id" class="form-select shadow-none" onchange="this.form.submit()">
                        <option value="all" {{ $selectedCourse == 'all' ? 'selected' : '' }}>All Courses</option>
                        @foreach ($coursesList as $c)
                            <option value="{{ $c->id }}" {{ $selectedCourse == $c->id ? 'selected' : '' }}>
                                {{ $c->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Button -->
                <div class="col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm fw-semibold">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                </div>

            </form>
        </div>

        <!-- Students Table Card -->
        <div class="card p-4 mb-4 students-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Enrolled Course</th>
                            <th>Enrolled Date</th>
                            <th>Progress</th>
                            <th class="text-end">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            @php
                                $progress = $student->progress ?? 0;
                                $enrolledDate = $student->created_at ? $student->created_at->format('M d, Y') : 'N/A';

                                $progressBarBg = 'bg-primary';
                                if ($progress >= 100) {
                                    $progressBarBg = 'bg-success';
                                } elseif ($progress < 30) {
                                    $progressBarBg = 'bg-warning';
                                }

                                $statusText = 'Active';
                                $statusBadgeClass = 'bg-success-subtle text-success border-success-subtle';

                                if ($progress >= 100) {
                                    $statusText = 'Completed';
                                    $statusBadgeClass = 'bg-primary-subtle text-primary border-primary-subtle';
                                } elseif (isset($student->status) && $student->status == 'inactive') {
                                    $statusText = 'Inactive';
                                    $statusBadgeClass = 'bg-secondary-subtle text-secondary border-secondary-subtle';
                                }
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=0d6efd&color=fff"
                                            class="rounded-circle me-3" width="42" height="42" alt="Avatar">
                                        <div>
                                            <div class="fw-semibold">{{ $student->name }}</div>
                                            <div class="small text-muted">{{ $student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $student->enrolledCourses->pluck('title')->implode(', ') ?: 'General Student' }}
                                    </span>
                                </td>
                                <td><span class="small text-muted">{{ $enrolledDate }}</span></td>
                                <td style="width: 200px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height: 7px; background-color: var(--border-color);">
                                            <div class="progress-bar {{ $progressBarBg }}" role="progressbar"
                                                style="width: {{ $progress }}%;"
                                                aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="small fw-semibold">{{ $progress }}%</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="badge {{ $statusBadgeClass }} border px-3 py-1 rounded-pill small fw-normal">
                                        {{ $statusText }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-user-slash fs-2 mb-2 d-block opacity-50"></i>
                                    No students found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection