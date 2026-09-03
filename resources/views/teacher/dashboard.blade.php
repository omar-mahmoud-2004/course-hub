@extends('layouts.app')

@section('title', 'Teacher Dashboard - CourseHub')

@section('content')
    <style>
        .teacher-dashboard {
            background-color: var(--bg-color);
            min-height: 85vh;
            transition: background-color 0.3s ease;
        }

        .stat-card {
            background-color: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .dashboard-table-card {
            background-color: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px;
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

    <div class="teacher-dashboard py-4">
        <div class="container-fluid px-4 px-lg-5">

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show my-3 rounded-3" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Welcome Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-2 rounded-pill px-3 py-2 fw-semibold">
                        TEACHER PANEL
                    </span>
                    <h2 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name ?? 'Professor' }}! 👋</h2>
                    <p class="text-muted mb-0">Here is an overview of your created courses.</p>
                </div>
                <a href="{{ route('courses.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-semibold">
                    <i class="fa-solid fa-plus me-2"></i> Create New Course
                </a>
            </div>

            <!-- Stats Cards Row -->
            <div class="row g-4 mb-4">
                <!-- Stat 1: My Courses -->
                <div class="col-12 col-md-4">
                    <div class="card p-4 d-flex flex-row align-items-center h-100 stat-card">
                        <div class="me-3 flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle"
                            style="width: 52px; height: 52px; background-color: rgba(37, 99, 235, 0.12); color: #2563eb; font-size: 1.25rem;">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div>
                            <span class="text-muted d-block small fw-semibold">My Created Courses</span>
                            <h3 class="fw-bold mb-0">{{ number_format($totalCourses) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat 2: Total Students -->
                <div class="col-12 col-md-4">
                    <div class="card p-4 d-flex flex-row align-items-center h-100 stat-card">
                        <div class="me-3 flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle"
                            style="width: 52px; height: 52px; background-color: rgba(14, 165, 233, 0.12); color: #0284c7; font-size: 1.25rem;">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div>
                            <span class="text-muted d-block small fw-semibold">Total Students</span>
                            <h3 class="fw-bold mb-0">{{ number_format($totalStudents) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat 3: Rating -->
                <div class="col-12 col-md-4">
                    <div class="card p-4 d-flex flex-row align-items-center h-100 stat-card">
                        <div class="me-3 flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle"
                            style="width: 52px; height: 52px; background-color: rgba(217, 119, 6, 0.12); color: #d97706; font-size: 1.25rem;">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <span class="text-muted d-block small fw-semibold">Average Rating</span>
                            <h3 class="fw-bold mb-0">{{ number_format($averageRating, 1) }} <span class="fs-6 text-muted fw-normal">/ 5.0</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Courses Table -->
            <div class="card p-4 mb-4 dashboard-table-card">
                <div class="mb-4">
                    <h5 class="fw-bold mb-1">My Courses</h5>
                    <p class="text-muted small mb-0">List of courses created by you.</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Course Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allCourses as $course)
                                @php
                                    $imgPath = (!empty($course->image) && file_exists(public_path('storage/' . $course->image)))
                                        ? asset('storage/' . $course->image)
                                        : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=100&q=80';
                                @endphp
                                <tr>
                                    <td class="fw-semibold">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $imgPath }}" class="me-3 rounded-3" alt="{{ $course->title }}"
                                                style="width: 48px; height: 48px; object-fit: cover;">
                                            <span>{{ $course->title }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill border border-primary-subtle">
                                            {{ $course->category->name ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-success">${{ number_format($course->price, 2) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('courses.edit', $course->id) }}"
                                            class="btn btn-sm btn-outline-secondary rounded-circle me-1"
                                            style="width: 34px; height: 34px; line-height: 22px;"
                                            title="Edit Course">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <a href="{{ route('lessons.index', ['course_id' => $course->id]) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="fa-solid fa-video me-1"></i> Lessons
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fs-2 mb-2 d-block opacity-50"></i>
                                        No courses found for your account.
                                        <a href="{{ route('courses.create') }}" class="text-primary fw-semibold ms-1">Add your first course!</a>
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