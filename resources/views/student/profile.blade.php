@extends('layouts.app')

@section('title', 'Student Profile - CourseHub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary bg-gradient text-white p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow-sm" style="width:65px; height:65px; font-size: 1.8rem;">
                            @if(!empty($student->img))
                                <img src="{{ asset('uploads/users/' . $student->img) }}" class="rounded-circle w-100 h-100 object-fit-cover" alt="{{ $student->name }}">
                            @else
                                <i class="bi bi-person-fill"></i>
                            @endif
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">{{ $student->name }}</h4>
                            <span class="badge bg-light text-primary rounded-pill px-3 py-1 mt-1">Student Account</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4">Edit Profile Information</h5>

                    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" value="{{ old('name', $student->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror" value="{{ old('email', $student->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" placeholder="Leave blank to keep current">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-3" placeholder="Confirm new password">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Profile Avatar</label>
                            <input type="file" name="img" class="form-control rounded-3" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-save me-1"></i> Save Changes
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection