@extends('layouts.app')

@section('title', 'Categories - CourseHub')

@section('content')
<style>
    .categories-page {
        background-color: var(--bg-color);
        min-height: 85vh;
        transition: background-color 0.3s ease;
    }

    .category-card {
        position: relative;
        cursor: pointer;
        min-height: 160px;
        padding: 24px;
        border-radius: 16px;
        background-color: var(--card-bg) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        text-decoration: none;
        display: flex;
        flex-direction: column;
    }

    .category-card:hover {
        transform: translateY(-4px);
        border-color: var(--primary-color) !important;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.12);
    }

    .category-icon {
        width: 65px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        overflow: hidden;
        background-color: rgba(37, 99, 235, 0.1);
        color: var(--primary-color);
        margin-bottom: 16px;
    }

    .category-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-title {
        color: var(--text-color);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .category-count {
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .category-actions {
        position: absolute;
        top: 18px;
        right: 18px;
        display: flex;
        gap: 6px;
        z-index: 2;
    }
</style>

<div class="categories-page py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
            <div>
                <span class="badge bg-primary-subtle text-primary mb-2 rounded-pill px-3 py-2 fw-semibold">
                    CATEGORIES
                </span>
                <h1 class="fw-bold mb-1">Explore Domains</h1>
                <p class="text-muted mb-0">Select a category to browse related courses.</p>
            </div>

            @auth
                @if(Auth::user()->role === 'admin')
                    <div>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-semibold">
                            <i class="fa-solid fa-plus me-1"></i> Add Category
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse ($categories as $category)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="category-card h-100" onclick="window.location.href='{{ route('courses.index', ['category_id' => $category->id]) }}'">

                        @auth
                            @if(Auth::user()->role === 'admin')
                                <div class="category-actions" onclick="event.stopPropagation()">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 32px; height: 32px; padding: 0; line-height: 28px;" title="Edit">
                                        <i class="fa-solid fa-pen small"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px; padding: 0; line-height: 28px;" title="Delete">
                                            <i class="fa-solid fa-trash small"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth

                        <div class="category-icon">
                            @if (!empty($category->icon) && file_exists(public_path('storage/' . $category->icon)))
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}">
                            @else
                                <i class="fa-solid fa-layer-group fs-3"></i>
                            @endif
                        </div>

                        <div>
                            <h4 class="category-title">{{ $category->name }}</h4>
                            <span class="category-count">
                                <i class="fa-solid fa-book-open me-1"></i>
                                {{ $category->courses_count ?? $category->courses()->count() }} Courses
                            </span>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="card p-5 border-0 shadow-sm rounded-4 text-center">
                        <i class="fa-solid fa-folder-open fs-1 text-muted opacity-50 mb-3 d-block"></i>
                        <h4 class="fw-bold">No Categories Found</h4>
                        <p class="text-muted mb-0">No course categories have been added yet.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection