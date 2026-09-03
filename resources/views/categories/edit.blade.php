@extends('layouts.app')

@section('title', 'Edit Category - CourseHub')

@section('content')
<style>
    .cat-form-card {
        background-color: var(--card-bg) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 20px;
    }
    .form-control {
        background-color: var(--bg-color) !important;
        color: var(--text-color) !important;
        border: 1px solid var(--border-color) !important;
        min-height: 48px;
    }
    .form-control:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15) !important;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card border-0 shadow-lg cat-form-card overflow-hidden">
                <div class="p-4 bg-primary text-white">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-pen-to-square fs-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-white">Edit Category</h4>
                            <p class="mb-0 text-white-50 small">Updating: <strong>{{ $category->name }}</strong></p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                class="form-control rounded-3 @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(!empty($category->icon) && file_exists(public_path('storage/' . $category->icon)))
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted d-block">Current Icon</label>
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}" style="width: 48px; height: 48px; object-fit: cover;" class="rounded-3 border">
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="icon" class="form-label fw-bold">Change Icon</label>
                            <input type="file" name="icon" id="icon"
                                class="form-control rounded-3 @error('icon') is-invalid @enderror"
                                accept="image/*">
                            <small class="text-muted mt-1 d-block">Leave blank to keep the current icon.</small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top" style="border-color: var(--border-color) !important;">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">
                                Back
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection