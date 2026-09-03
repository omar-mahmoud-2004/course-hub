@extends('layouts.app')

@section('title', 'CourseHub - Learning Platform')

@section('content')

<style>
    /* ========================================================
       1. الوضع الفاتح الافتراضي (Light Mode - خلفية ثلجية زرقاء ناعمة)
       ======================================================== */
    .hero-tech-banner {
        position: relative;
        background-color: #f0f7ff;
        background-image: 
            radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.14) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(14, 165, 233, 0.14) 0px, transparent 50%),
            radial-gradient(at 50% 50%, rgba(224, 242, 254, 0.6) 0px, transparent 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 85px 0 75px;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .hero-tech-banner::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(37, 99, 235, 0.1) 1px, transparent 1px);
        background-size: 26px 26px;
        pointer-events: none;
        opacity: 0.8;
    }

    /* نصوص الوضع الفاتح */
    .hero-title {
        color: #0f172a;
        font-weight: 800;
        letter-spacing: -1.2px;
        line-height: 1.2;
    }

    .hero-desc {
        color: #475569;
        line-height: 1.7;
    }

    .hero-btn-secondary {
        background: #ffffff;
        color: #1e293b;
        border: 1px solid #cbd5e1;
    }
    .hero-btn-secondary:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    /* ========================================================
       2. الوضع الليلي (Dark Mode - الكحلي المتوهج الأصلي)
       ======================================================== */
    [data-bs-theme="dark"] .hero-tech-banner {
        background-color: #0b1120;
        background-image: 
            radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.35) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(14, 165, 233, 0.22) 0px, transparent 50%),
            radial-gradient(at 50% 50%, rgba(30, 41, 59, 0.6) 0px, transparent 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    [data-bs-theme="dark"] .hero-tech-banner::before {
        background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        opacity: 0.5;
    }

    [data-bs-theme="dark"] .hero-title {
        color: #ffffff !important;
    }

    [data-bs-theme="dark"] .hero-desc {
        color: rgba(255, 255, 255, 0.75) !important;
    }

    [data-bs-theme="dark"] .hero-btn-secondary {
        background: transparent;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.35);
    }
    [data-bs-theme="dark"] .hero-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    /* شاشة الكود (تظل بتصميم IDE الداكن المميز في الحالتين) */
    .hero-code-box {
        background: #030712 !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
    }

    /* باقي التنسيقات العامة */
    .stats-strip {
        background-color: var(--card-bg);
        border-bottom: 1px solid var(--border-color);
    }
    .courses-section {
        background-color: var(--bg-color);
        border-top: 1px solid var(--border-color);
    }
    .cat-box {
        background-color: var(--card-bg) !important;
        border: 1px solid var(--border-color) !important;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
    }
    .cat-box:hover {
        transform: translateY(-4px);
        border-color: var(--primary-color) !important;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.12) !important;
    }
    .course-card-img {
        height: 200px;
        object-fit: cover;
    }
    .icon-wrapper {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
</style>

<!-- 1. Hero Section -->
<section id="home" class="hero-tech-banner position-relative overflow-hidden">
    <div class="container py-lg-3 position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 shadow-sm mb-4">
                    <i class="fa-solid fa-bolt-lightning text-warning"></i>
                    <span class="small fw-bold">Online Courses & Tutorials</span>
                </div>

                <h1 class="display-4 hero-title mb-3">
                    Learn and Teach on <span class="text-primary">CourseHub</span>
                </h1>

                <p class="hero-desc mb-4 lead fs-6">
                    A streamlined platform for sharing knowledge, tracking student progress, and exploring programming, design, and business courses.
                </p>

                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('courses.index') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg">
                        Explore Courses <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn hero-btn-secondary rounded-pill px-4 py-3 fw-bold">
                            Join Now
                        </a>
                    @endguest
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card p-4 rounded-4 hero-code-box">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                        <span class="rounded-circle bg-danger d-inline-block" style="width: 10px; height: 10px;"></span>
                        <span class="rounded-circle bg-warning d-inline-block" style="width: 10px; height: 10px;"></span>
                        <span class="rounded-circle bg-success d-inline-block" style="width: 10px; height: 10px;"></span>
                        <span class="text-secondary small ms-2 fw-mono">// app-overview.php</span>
                    </div>
                    <pre class="mb-0 text-light" style="font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9rem; line-height: 1.7;">
<span style="color: #c678dd;">&lt;?php</span>
<span style="color: #e06c75;">$platform</span> = [
    <span style="color: #98c379;">"courses"</span>  => <span style="color: #d19a66;">{{ $totalCourses }}</span>,
    <span style="color: #98c379;">"students"</span> => <span style="color: #d19a66;">{{ $totalStudents }}</span>,
    <span style="color: #98c379;">"teachers"</span> => <span style="color: #d19a66;">{{ $totalTeachers }}</span>,
];
<span style="color: #5c6370;">// Live platform statistics</span></pre>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 2. Real Stats Strip -->
<section class="py-4 stats-strip">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="bg-primary-subtle text-primary icon-wrapper">
                        <i class="fa-solid fa-book-open fs-5"></i>
                    </div>
                    <div class="text-start">
                        <h4 class="fw-bold mb-0">{{ $totalCourses }}</h4>
                        <small class="text-muted">Total Courses</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="bg-success-subtle text-success icon-wrapper">
                        <i class="fa-solid fa-user-graduate fs-5"></i>
                    </div>
                    <div class="text-start">
                        <h4 class="fw-bold mb-0">{{ $totalStudents }}</h4>
                        <small class="text-muted">Enrolled Students</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="bg-warning-subtle text-warning-emphasis icon-wrapper">
                        <i class="fa-solid fa-chalkboard-user fs-5"></i>
                    </div>
                    <div class="text-start">
                        <h4 class="fw-bold mb-0">{{ $totalTeachers }}</h4>
                        <small class="text-muted">Teachers</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. Real Categories Section -->
<section id="categories" class="py-5">
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold mb-1">Categories</h3>
                <p class="text-muted small mb-0">Browse courses by category</p>
            </div>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                All Categories <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3">
            @forelse ($topCategories as $category)
                <div class="col-6 col-md-3">
                    <a href="{{ route('courses.index', ['category_id' => $category->id]) }}" class="card p-3 text-center cat-box h-100 shadow-sm rounded-4">
                        <div class="bg-primary-subtle text-primary rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            @if($category->icon && file_exists(public_path('storage/' . $category->icon)))
                                <img src="{{ asset('storage/' . $category->icon) }}" style="width: 26px; height: 26px; object-fit: contain;" alt="">
                            @else
                                <i class="fa-solid fa-folder fs-5"></i>
                            @endif
                        </div>
                        <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                        <span class="text-muted small">{{ $category->courses_count }} {{ Str::plural('Course', $category->courses_count) }}</span>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">
                    <p class="mb-0">No categories created yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 4. Real Featured Courses Section -->
<section id="courses" class="py-5 courses-section">
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold mb-1">Latest Courses</h3>
                <p class="text-muted small mb-0">Recently added courses on the platform</p>
            </div>
            <a href="{{ route('courses.index') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                View All <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse ($featuredCourses as $course)
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-4 overflow-hidden h-100">
                        @php
                            $img = (!empty($course->image) && file_exists(public_path('storage/' . $course->image)))
                                ? asset('storage/' . $course->image)
                                : "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&q=80";
                        @endphp
                        <img src="{{ $img }}" class="card-img-top course-card-img" alt="{{ $course->title }}">
                        
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 small">
                                    {{ $course->category->name ?? 'General' }}
                                </span>
                                <span class="fw-bold text-success fs-5">
                                    {{ $course->price == 0 ? 'Free' : '$' . number_format($course->price, 2) }}
                                </span>
                            </div>
                            
                            <h5 class="fw-bold mb-2">{{ $course->title }}</h5>
                            <p class="text-muted small mb-3 flex-grow-1">
                                {{ Str::limit($course->description, 85) }}
                            </p>

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center" style="border-color: var(--border-color) !important;">
                                <small class="text-muted">
                                    <i class="fa-solid fa-user me-1"></i> {{ $course->teacher->name ?? 'Instructor' }}
                                </small>
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fa-solid fa-folder-open fs-2 mb-2 d-block"></i>
                    <p class="mb-0">No courses uploaded yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection