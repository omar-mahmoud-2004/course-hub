```blade
@extends('layouts.app')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<main class="main-content flex-grow-1 w-100">

    <div class="container-fluid py-4 px-4 px-lg-5">

        {{-- Course Information --}}
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">

            <div class="row g-0">

                {{-- Course Image --}}
                <div class="col-md-4">

                    @if(!empty($course->image))

                        <img
                            src="{{ asset('storage/' . $course->image) }}"
                            alt="{{ $course->title }}"
                            style="width:100%;height:280px;object-fit:cover;">

                    @else

                        <div class="d-flex align-items-center justify-content-center bg-light"
                             style="height:280px;">

                            <i class="fa-solid fa-book-open fa-4x text-muted"></i>

                        </div>

                    @endif

                </div>


                {{-- Course Details --}}
                <div class="col-md-8">

                    <div class="card-body p-4 p-lg-5">

                        {{-- Category --}}
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">

                            {{ $course->category->name ?? 'General' }}

                        </span>


                        {{-- Title --}}
                        <h2 class="fw-bold mb-3">
                            {{ $course->title }}
                        </h2>


                        {{-- Description --}}
                        <p class="text-muted mb-4">
                            {{ $course->description }}
                        </p>


                        {{-- Course Information --}}
                        <div class="d-flex gap-4 text-muted">

                            <span>
                                <i class="fa-solid fa-book me-2"></i>
                                {{ $lessons->count() }} Lessons
                            </span>

                            <span>
                                <i class="fa-solid fa-dollar-sign me-2"></i>
                                {{ number_format((float) $course->price, 2) }}
                            </span>

                        </div>


                        {{-- Quiz --}}
                        <div class="mt-4">

                            <a href="{{ route('student.quiz', $course->id) }}"
                               class="btn btn-primary rounded-3 px-4">

                                <i class="fa-solid fa-clipboard-question me-2"></i>
                                Take Quiz

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Course Lessons --}}
        <div class="card border-0 shadow-sm rounded-3 p-4">

            <div class="mb-4">

                <h4 class="fw-bold mb-1">
                    Course Lessons
                </h4>

                <p class="text-muted small mb-0">
                    Start learning by choosing a lesson.
                </p>

            </div>


            {{-- Check Lessons --}}
            @if($lessons->count() > 0)

                <div class="list-group">

                    @foreach($lessons as $index => $lesson)

                        <a href="{{ route('student.lesson', $lesson->id) }}"
                           class="list-group-item list-group-item-action border-0 shadow-sm rounded-3 mb-2 p-3">

                            <div class="d-flex align-items-center">

                                <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary me-3"
                                     style="width:45px;height:45px;">

                                    <i class="fa-solid fa-play"></i>

                                </div>


                                <div>

                                    <h6 class="fw-bold mb-1">

                                        Lesson {{ $index + 1 }}:
                                        {{ $lesson->title }}

                                    </h6>

                                    <small class="text-muted">

                                        Click to start this lesson

                                    </small>

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                <div class="text-center py-5">

                    <i class="fa-solid fa-video-slash fa-3x text-muted mb-3"></i>

                    <h5 class="fw-bold">
                        No Lessons Yet
                    </h5>

                    <p class="text-muted mb-0">

                        This course doesn't have any lessons yet.

                    </p>

                </div>

            @endif

        </div>

    </div>

</main>

@endsection
```
