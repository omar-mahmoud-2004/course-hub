@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <!-- Card -->
                <div class="card shadow border-0 rounded-4">

                    <!-- Header -->
                    <div class="card-header bg-warning text-dark text-center py-4 rounded-top-4">
                        <h2 class="fw-bold mb-1">Edit Course</h2>
                        <p class="mb-0">Update course information</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4 p-md-5">

                        <!-- Error Messages Alert -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('courses.update', $course->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Course Title -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Course Title</label>
                                <input class="form-control form-control-lg" type="text" name="title"
                                    value="{{ old('title', $course->title) }}" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control" name="description" rows="5"
                                    required>{{ old('description', $course->description) }}</textarea>
                            </div>

                            <!-- Current Image -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold d-block">Current Image</label>
                                @if (!empty($course->image))
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                                        class="img-thumbnail mb-3" style="width: 160px; height: 100px; object-fit: cover;">
                                @else
                                    <p class="text-secondary">No image available</p>
                                @endif
                            </div>

                            <!-- New Image -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">New Image</label>
                                <input class="form-control form-control-lg" type="file" name="image" accept="image/*">
                                <div class="form-text">Leave empty to keep the current image.</div>
                            </div>

                            <!-- Price -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Price</label>
                                <input class="form-control form-control-lg" type="number" name="price" min="0" step="0.01"
                                    value="{{ old('price', $course->price) }}" required>
                            </div>

                            <!-- Category -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Category</label>
                                <select class="form-select form-select-lg" name="category_id" required>
                                    <option value="">Choose Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id', $course->category_id) == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Created At -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Created At</label>
                                <input class="form-control form-control-lg" type="datetime-local" name="created_at"
                                    value="{{ old('created_at', \Carbon\Carbon::parse($course->created_at)->format('Y-m-d\TH:i')) }}"
                                    required>
                            </div>

                            <!-- Buttons -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-warning btn-lg rounded-3">
                                    Update Course
                                </button>
                                <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary btn-lg rounded-3">
                                    Back to Courses
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection