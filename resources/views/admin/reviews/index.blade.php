@extends('layouts.admin')

@section('title', 'Reviews Management - CourseHub')

@section('content')
<div class="container py-5">

    <!-- Header & Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <small class="text-primary fw-bold text-uppercase">ADMIN PANEL</small>
            <h1 class="fw-bold mt-1 mb-0">Reviews Management</h1>
            <p class="text-secondary fs-6 mb-0">Moderate student reviews, feedback, and course ratings.</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-people me-1"></i> Users
            </a>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-book me-1"></i> Courses
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-tags me-1"></i> Categories
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary">
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

    <!-- Reviews Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-star-half text-warning me-2"></i>All Reviews ({{ $reviews->total() }})
            </h5>

            <!-- Filter by Rating & Search -->
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex gap-2 col-md-6">
                <select name="rating" class="form-select form-select-sm w-auto">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('rating') == 2 ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('rating') == 1 ? 'selected' : '' }}>1 Star</option>
                </select>

                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search feedback..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-primary px-3">Filter</button>
                @if(request('search') || request('rating'))
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-light border">Reset</a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr>
                            <td class="text-muted fw-bold">#{{ $review->id }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $review->user->name ?? 'Deleted Student' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border">
                                    {{ $review->course->title ?? 'Deleted Course' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star text-muted opacity-25"></i>
                                        @endif
                                    @endfor
                                </span>
                                <small class="fw-bold ms-1 text-secondary">({{ $review->rating }}/5)</small>
                            </td>
                            <td>
                                <span class="text-secondary small">{{ $review->comment ?? 'No written comment' }}</span>
                            </td>
                            <td class="text-muted small">
                                {{ $review->created_at ? $review->created_at->format('Y-m-d') : '-' }}
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Review">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No reviews found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $reviews->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection