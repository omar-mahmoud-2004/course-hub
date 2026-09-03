@extends('layouts.app')

@section('title', 'Add Category - CourseHub')

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
                            <i class="fa-solid fa-folder-plus fs-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-white">New Category</h4>
                            <p class="mb-0 text-white-50 small">Create a domain to organize courses.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control rounded-3 @error('name') is-invalid @enderror"
                                placeholder="e.g. Web Development" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="form-label fw-bold">Icon or Image (Optional)</label>
                            <input type="file" name="icon" id="icon"
                                class="form-control rounded-3 @error('icon') is-invalid @enderror"
                                accept="image/*">
                            <small class="text-muted mt-1 d-block">Recommended: PNG or SVG with transparent background.</small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top" style="border-color: var(--border-color) !important;">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">
                                Back
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection