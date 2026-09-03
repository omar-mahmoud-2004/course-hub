@extends('layouts.admin')

@section('title', 'Courses Management - CourseHub')

@section('content')
<div class="container py-5">

    <!-- Header & Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <small class="text-primary fw-bold text-uppercase">ADMIN PANEL</small>
            <h1 class="fw-bold mt-1 mb-0">Courses Management</h1>
            <p class="text-secondary fs-6 mb-0">Monitor and manage all courses uploaded across the platform.</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-people me-1"></i> Users
            </a>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-primary">
                <i class="bi bi-book me-1"></i> Courses
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-tags me-1"></i> Categories
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-star me-1"></i> Reviews
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Courses Table Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-journal-code text-primary me-2"></i>All Courses ({{ $courses->total() }})
            </h5>

            <!-- Filter & Search Form -->
            <form method="GET" action="{{ route('admin.courses.index') }}" class="d-flex gap-2 col-md-7">
                <select name="category_id" class="form-select form-select-sm w-auto">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search title..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-primary px-3">Filter</button>
                @if(request('search') || request('category_id'))
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-light border">Reset</a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Course Title</th>
                        <th>Instructor</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Reviews</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr>
                            <td class="text-muted fw-bold">#{{ $course->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $course->title }}</div>
                                <small class="text-muted">{{ Str::limit($course->description, 45) }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold text-secondary">
                                    <i class="bi bi-person me-1"></i>{{ $course->teacher->name ?? 'Unassigned' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border">
                                    {{ $course->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td>
                                @if($course->price == 0)
                                    <span class="badge bg-success">Free</span>
                                @else
                                    <span class="fw-bold text-dark">${{ number_format($course->price, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-warning border text-dark">
                                    <i class="bi bi-star-fill text-warning me-1"></i> {{ $course->reviews_count }}
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Course">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No courses found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $courses->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection