@extends('layouts.app')

@section('title', $pageTitle)

@section('content')

    <style>
        .course-create-page {
            min-height: 85vh;
            background-color: var(--bg-color);
            transition: background-color 0.3s ease;
        }

        /* Header */
        .course-header {
            background: linear-gradient(135deg, #0d6efd, #3b82f6);
            border-radius: 20px;
            padding: 30px 35px;
            color: white;
            box-shadow: 0 10px 30px rgba(13, 110, 253, 0.18);
        }

        .course-header h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #ffffff !important;
        }

        .course-header p {
            margin: 0;
            opacity: 0.9;
            color: rgba(255, 255, 255, 0.9) !important;
        }

        /* Back Button */
        .back-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: white !important;
            padding: 10px 18px;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .back-btn:hover {
            background: white;
            color: #0d6efd !important;
            transform: translateY(-2px);
        }

        /* Form Card */
        .course-form-card {
            border: 1px solid var(--border-color) !important;
            border-radius: 20px;
            overflow: hidden;
            background-color: var(--card-bg) !important;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.05);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .form-card-header {
            padding: 25px 30px;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--card-bg);
        }

        .form-card-header h5 {
            margin: 0;
            font-weight: 700;
            color: var(--text-color) !important;
        }

        .form-card-header p {
            margin: 5px 0 0;
            color: var(--text-muted) !important;
            font-size: 14px;
        }

        .form-card-body {
            padding: 30px;
        }

        /* Labels */
        .form-label {
            color: var(--text-color);
            font-size: 14px;
            margin-bottom: 8px;
        }

        /* Inputs */
        .form-control,
        .form-select {
            min-height: 48px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 14px;
            background-color: var(--bg-color) !important;
            color: var(--text-color) !important;
            transition: all 0.2s ease;
            box-shadow: none;
        }

        textarea.form-control {
            min-height: 130px;
            resize: vertical;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15) !important;
        }

        .form-control::placeholder {
            color: var(--text-muted);
            opacity: 0.7;
        }

        /* Icons inside inputs */
        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
            z-index: 2;
        }

        .input-with-icon {
            padding-left: 43px;
        }

        /* Upload Box */
        .image-upload-box {
            border: 2px dashed var(--border-color);
            border-radius: 14px;
            padding: 22px;
            background-color: var(--bg-color);
            transition: all 0.3s ease;
        }

        .image-upload-box:hover {
            border-color: var(--primary-color);
            background-color: rgba(37, 99, 235, 0.03);
        }

        .image-upload-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .image-help {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 8px;
        }

        /* Buttons */
        .form-actions {
            border-top: 1px solid var(--border-color);
            margin-top: 30px;
            padding-top: 25px;
        }

        .create-btn {
            min-height: 48px;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .create-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 18px rgba(13, 110, 253, 0.25);
        }

        .cancel-btn {
            min-height: 48px;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 500;
            background-color: var(--card-bg);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .cancel-btn:hover {
            background-color: var(--bg-color);
            color: var(--text-color);
            transform: translateY(-2px);
        }

        /* Responsive Mobile Styles */
        @media (max-width: 768px) {
            .course-create-page {
                padding-top: 20px !important;
            }

            .course-header {
                padding: 25px 20px;
                flex-direction: column;
                align-items: flex-start !important;
                gap: 18px;
            }

            .course-header h2 {
                font-size: 23px;
            }

            .back-btn,
            .create-btn,
            .cancel-btn {
                width: 100%;
                text-align: center;
                justify-content: center;
            }

            .form-card-body,
            .form-card-header {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>

    <div class="course-create-page py-5">
        <div class="container">

            <div class="course-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>
                        <i class="fa-solid fa-circle-plus me-2"></i>
                        {{ $pageTitle }}
                    </h2>
                    <p>{{ $pageSubTitle }}</p>
                </div>
                <a href="{{ route('courses.index') }}" class="btn back-btn">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Back to Courses
                </a>
            </div>

            <div class="course-form-card">
                <div class="form-card-header">
                    <h5>
                        <i class="fa-solid fa-book-open me-2 text-primary"></i>
                        Course Information
                    </h5>
                    <p>Fill in the information below to create a new course.</p>
                </div>

                <div class="form-card-body">
                    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <div class="col-12">
                                <label for="title" class="form-label fw-semibold">Course Title</label>
                                <div class="input-icon-wrapper">
                                    <i class="fa-solid fa-book input-icon"></i>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                        class="form-control input-with-icon @error('title') is-invalid @enderror"
                                        placeholder="Enter course title" required>
                                </div>
                                @error('title')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea name="description" id="description" rows="5"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter course description" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="price" class="form-label fw-semibold">Price</label>
                                <div class="input-icon-wrapper">
                                    <i class="fa-solid fa-dollar-sign input-icon"></i>
                                    <input type="number" name="price" id="price" step="0.01" min="0"
                                        value="{{ old('price') }}"
                                        class="form-control input-with-icon @error('price') is-invalid @enderror"
                                        placeholder="0.00" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-semibold">Category</label>
                                <select name="category_id" id="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="image" class="form-label fw-semibold">Course Image</label>
                                <div class="image-upload-box">
                                    <div class="image-upload-icon">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                    </div>
                                    <input type="file" name="image" id="image"
                                        class="form-control @error('image') is-invalid @enderror">
                                    <div class="image-help">
                                        Recommended: JPG, JPEG, PNG or GIF. Maximum size: 2MB.
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-actions d-flex gap-2">
                            <button type="submit" class="btn btn-primary create-btn">
                                <i class="fa-solid fa-plus me-2"></i> Create Course
                            </button>
                            <a href="{{ route('courses.index') }}" class="btn cancel-btn">
                                <i class="fa-solid fa-xmark me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection