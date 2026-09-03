@extends('layouts.app')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<main class="main-content flex-grow-1 w-100">

    <div class="container-fluid py-4 px-4 px-lg-5">

        <!-- Back -->
        <div class="mb-4">

            <a href="{{ url('/student/course/' . $course->id) }}"
               class="text-decoration-none text-muted">

                <i class="fa-solid fa-arrow-left me-2"></i>

                Back to Course

            </a>

        </div>


        <!-- Quiz Header -->

        <div class="card border-0 shadow-sm rounded-3 mb-4">

            <div class="card-body p-4 p-lg-5">

                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">

                    QUIZ

                </span>

                <h2 class="fw-bold mb-2">

                    {{ $course->title }}

                </h2>

                <p class="text-muted mb-0">

                    Test your knowledge of this course.

                </p>

            </div>

        </div>


        {{-- ========================= --}}
        {{-- Quiz Result --}}
        {{-- ========================= --}}

        @isset($score)

            <div class="card border-0 shadow-sm rounded-3 mb-4">

                <div class="card-body text-center p-5">

                    <i class="fa-solid fa-circle-check text-success fa-4x mb-3"></i>

                    <h3 class="fw-bold">

                        Quiz Completed 🎉

                    </h3>

                    <p class="text-muted">

                        Your Score

                    </p>

                    <h1 class="fw-bold text-primary">

                        {{ $score }} / {{ $total }}

                    </h1>

                    <h4 class="fw-bold">

                        {{ $percentage }}%

                    </h4>

                    <a href="{{ route('student.quiz', $course->id) }}"
                       class="btn btn-primary rounded-3 px-4 mt-3">

                        Try Again

                    </a>

                </div>

            </div>


        {{-- ========================= --}}
        {{-- No Questions --}}
        {{-- ========================= --}}

        @elseif($questions->isEmpty())

            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-body text-center py-5">

                    <i class="fa-solid fa-clipboard-question fa-4x text-muted mb-3"></i>

                    <h4 class="fw-bold">

                        No Quiz Questions Yet

                    </h4>

                    <p class="text-muted">

                        There are no questions available for this course yet.

                    </p>

                </div>

            </div>


        {{-- ========================= --}}
        {{-- Quiz Form --}}
        {{-- ========================= --}}

        @else

            <form method="POST"
                  action="{{ route('student.quiz.submit', $course->id) }}">

                @csrf

                @foreach($questions as $index => $q)

                    <div class="card border-0 shadow-sm rounded-3 mb-4">

                        <div class="card-body p-4">

                            <h5 class="fw-bold mb-4">

                                Question {{ $index + 1 }}

                            </h5>

                            <p class="fs-5 mb-4">

                                {{ $q->question }}

                            </p>


                            <!-- Answer -->

                            <div class="mb-3">

                                <input
                                    type="text"
                                    name="answer[{{ $q->id }}]"
                                    class="form-control form-control-lg"
                                    placeholder="Write your answer..."
                                    required>

                            </div>

                        </div>

                    </div>

                @endforeach


                <!-- Submit -->

                <div class="text-center">

                    <button type="submit"
                            class="btn btn-success btn-lg rounded-3 px-5">

                        <i class="fa-solid fa-check me-2"></i>

                        Submit Quiz

                    </button>

                </div>

            </form>

        @endif

    </div>

</main>

@endsection