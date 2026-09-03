@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <div>
                <h2 class="fw-bold mb-1">{{ $pageTitle }}</h2>
                <p class="text-muted mb-0">{{ $pageSubTitle }}</p>
            </div>

            <div class="d-flex gap-2">

                <!-- Back to Categories for Student -->
                @if ($role === 'student')
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3 shadow-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i>
                        Back to Categories
                    </a>
                @endif

                <!-- Add Course for Teacher/Admin -->
                @if ($role === 'teacher' || $role === 'admin')
                    <a href="{{ route('courses.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                        <i class="fa-solid fa-plus me-2"></i>
                        Add New Course
                    </a>
                @endif

            </div>

        </div>

        <!-- Courses Grid -->
        <div class="row g-4">

            @if ($courses->count() > 0)

                @foreach ($courses as $course)

                    @php
                        $imagePath = (!empty($course->image) && file_exists(public_path('storage/' . $course->image)))
                            ? asset('storage/' . $course->image)
                            : "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&q=80";
                    @endphp

                    <div class="col-md-6 col-lg-4">

                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">

                            <!-- Course Image -->
                            <img src="{{ $imagePath }}" class="card-img-top" alt="{{ $course->title }}"
                                style="height: 200px; object-fit: cover;">

                            <div class="card-body p-4 d-flex flex-column">

                                <!-- Category + Price -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold">
                                        {{ $course->category->name ?? 'General' }}
                                    </span>

                                    <span class="fw-bold text-success fs-5">
                                        ${{ number_format($course->price, 2) }}
                                    </span>
                                </div>

                                <!-- Course Title -->
                                <h5 class="card-title fw-bold text-dark mb-1">
                                    {{ $course->title }}
                                </h5>

                                <!-- Teacher -->
                                <div class="text-muted small mb-3">
                                    <i class="fa-solid fa-user-chalkboard me-1 text-secondary"></i>
                                    By:
                                    <span class="fw-semibold text-dark">
                                        {{ $course->teacher->name ?? 'Unknown Instructor' }}
                                    </span>
                                </div>

                                <!-- Description -->
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($course->description ?? '', 100) }}
                                </p>

                                <!-- Buttons Section -->
                                <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center">

                                    <!-- أزرار العرض والتعديل معاً -->
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary rounded-3 btn-sm">
                                            <i class="fa-solid fa-eye me-1"></i>
                                            View Course
                                        </a>

                                        @if (
                                                $role === 'admin' ||
                                                ($role === 'teacher' && $user_id == $course->teacher_id)
                                            )
                                            <a href="{{ route('courses.edit', $course->id) }}"
                                                class="btn btn-sm btn-light rounded-circle text-secondary" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        @endif
                                    </div>

                                    <!-- زر اللدروس يكون في أقصى الطرف الآخر -->
                                    <a href="{{ route('lessons.index', ['course_id' => $course->id]) }}"
                                        class="btn btn-outline-primary rounded-3 btn-sm">
                                        <i class="fa-solid fa-video me-1"></i>
                                        Lessons
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            @else

                <!-- No Courses -->
                <div class="col-12 text-center py-5">
                    <div class="card border-0 shadow-sm p-5 rounded-4 bg-white">
                        <i class="fa-solid fa-folder-open text-muted fs-1 mb-3"></i>
                        <h4 class="fw-bold">No Courses Found</h4>
                        <p class="text-muted">
                            @if ($role === 'teacher')
                                You haven't added any courses yet.
                            @else
                                There are no courses available yet.
                            @endif
                        </p>

                        @if ($role === 'teacher')
                            <div>
                                <a href="{{ route('courses.create') }}" class="btn btn-primary px-4 py-2 rounded-3">
                                    <i class="fa-solid fa-plus me-2"></i>
                                    Create First Course
                                </a>
                            </div>
                        @else
                            <div>
                                <a href="{{ route('categories.index') }}" class="btn btn-primary px-4 py-2 rounded-3">
                                    Browse Categories
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            @endif

        </div>

    </div>

@endsection