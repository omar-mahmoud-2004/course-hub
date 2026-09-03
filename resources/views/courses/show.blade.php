@extends('layouts.app')

@section('title', $course->title . ' - CourseHub')

@section('content')
<style>
    .course-details-page {
        background-color: var(--bg-color);
        min-height: 85vh;
        transition: background-color 0.3s ease;
    }

    .review-card {
        background-color: var(--card-bg) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 16px;
    }

    /* نظام اختيار النجوم بالـ Radio Buttons بتأثير Hover */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 6px;
    }
    .star-rating input {
        display: none;
    }
    .star-rating label {
        font-size: 26px;
        color: var(--border-color);
        cursor: pointer;
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #f59e0b !important;
        transform: scale(1.1);
    }
</style>

<div class="course-details-page py-5">
    <div class="container">
        
        <!-- التنبيهات -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-xmark me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- تفاصيل الكورس الأساسية -->
        <div class="card review-card p-4 mb-4 shadow-sm">
            <div class="row align-items-center g-4">
                <div class="col-md-4">
                    @php
                        $imgPath = (!empty($course->image) && file_exists(public_path('storage/' . $course->image)))
                            ? asset('storage/' . $course->image)
                            : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&q=80';
                    @endphp
                    <img src="{{ $imgPath }}" class="img-fluid rounded-4 shadow-sm w-100" style="height: 220px; object-fit: cover;" alt="{{ $course->title }}">
                </div>
                <div class="col-md-8">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2">
                        {{ $course->category->name ?? 'General' }}
                    </span>
                    <h2 class="fw-bold mb-2">{{ $course->title }}</h2>
                    <p class="text-muted mb-3">{{ $course->description }}</p>
                    
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pt-2 border-top">
                        <div class="d-flex align-items-center gap-4 text-muted small">
                            <span><i class="fa-solid fa-chalkboard-user me-1 text-primary"></i> {{ $course->teacher->name ?? 'Instructor' }}</span>
                            <span class="text-success fw-bold fs-5">${{ number_format($course->price, 2) }}</span>
                        </div>

                        <!-- أزرار الاشتراك ومتابعة الكورس -->
                        <div>
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                    <i class="fa-solid fa-right-to-bracket me-1"></i> Login to Enroll
                                </a>
                            @else
                                @if(Auth::id() === $course->teacher_id)
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                                        <i class="fa-solid fa-user-tie me-1"></i> Your Course
                                    </span>
                                @elseif(Auth::user()->enrolledCourses->contains($course->id))
                                    <a href="{{ route('student.course', $course->id) }}" class="btn btn-success rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                        <i class="fa-solid fa-circle-play me-1"></i> Continue Learning
                                    </a>
                                @else
                                    <form action="{{ route('courses.enroll', $course->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                            <i class="fa-solid fa-user-plus me-1"></i> Enroll Now
                                        </button>
                                    </form>
                                @endif
                            @endguest
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- قسم التقييمات (Reviews Section) -->
        <!-- ========================================== -->
        <div class="row g-4">
            
            <!-- نموذج كتابة التقييم (Write a Review) -->
            <div class="col-lg-5">
                <div class="card review-card p-4 shadow-sm h-100">
                    <h5 class="fw-bold mb-1">
                        <i class="fa-solid fa-pen-nib text-primary me-2"></i> Leave a Review
                    </h5>
                    <p class="text-muted small mb-4">Rate this course and share your learning experience.</p>

                    @auth
                        @if(Auth::id() !== $course->teacher_id)
                            @php
                                $myReview = $course->reviews->where('student_id', Auth::id())->first();
                            @endphp

                            <form action="{{ route('reviews.store', $course->id) }}" method="POST">
                                @csrf

                                <!-- اختيار النجوم -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-muted d-block">Your Rating</label>
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="rating" value="5" {{ old('rating', $myReview->rating ?? 5) == 5 ? 'checked' : '' }} />
                                        <label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>

                                        <input type="radio" id="star4" name="rating" value="4" {{ old('rating', $myReview->rating ?? 0) == 4 ? 'checked' : '' }} />
                                        <label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>

                                        <input type="radio" id="star3" name="rating" value="3" {{ old('rating', $myReview->rating ?? 0) == 3 ? 'checked' : '' }} />
                                        <label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>

                                        <input type="radio" id="star2" name="rating" value="2" {{ old('rating', $myReview->rating ?? 0) == 2 ? 'checked' : '' }} />
                                        <label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>

                                        <input type="radio" id="star1" name="rating" value="1" {{ old('rating', $myReview->rating ?? 0) == 1 ? 'checked' : '' }} />
                                        <label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
                                    </div>
                                    @error('rating')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- التعليق -->
                                <div class="mb-3">
                                    <label for="comment" class="form-label fw-semibold small text-muted">Feedback / Comment</label>
                                    <textarea name="comment" id="comment" rows="4" class="form-control" placeholder="What did you like or learn from this course?">{{ old('comment', $myReview->comment ?? '') }}</textarea>
                                    @error('comment')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold w-100 shadow-sm">
                                    <i class="fa-solid fa-paper-plane me-1"></i> {{ $myReview ? 'Update My Review' : 'Submit Review' }}
                                </button>
                            </form>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fa-solid fa-user-tie fs-2 mb-2 opacity-50 d-block"></i>
                                <p class="small mb-0">You are the instructor of this course.</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4 text-muted">
                            <p class="mb-3 small">Please log in to leave your feedback and rating.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold">
                                Login to Review
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- قائمة مراجعات الطلاب السابقة (Existing Reviews) -->
            <div class="col-lg-7">
                <div class="card review-card p-4 shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">
                            <i class="fa-solid fa-comments text-warning me-2"></i> Student Feedback
                        </h5>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1">
                            {{ $course->reviews->count() }} {{ Str::plural('Review', $course->reviews->count()) }}
                        </span>
                    </div>

                    <div class="reviews-list d-flex flex-column gap-3">
                        @forelse ($course->reviews as $review)
                            <div class="p-3 rounded-3" style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($review->student->name ?? 'Student') }}&background=0d6efd&color=fff" 
                                             class="rounded-circle" width="34" height="34" alt="avatar">
                                        <span class="fw-bold small">{{ $review->student->name ?? 'Verified Student' }}</span>
                                    </div>
                                    
                                    <!-- رسم النجوم الذهبية -->
                                    <div class="text-warning small">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-muted small mb-1">{{ $review->comment ?: 'No written comment provided.' }}</p>
                                <small class="text-secondary" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-clock me-1"></i> {{ $review->created_at->diffForHumans() }}
                                </small>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="fa-regular fa-star fs-2 mb-2 d-block opacity-50"></i>
                                <p class="small mb-0">No reviews yet. Be the first to review this course!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection