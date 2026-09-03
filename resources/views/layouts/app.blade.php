<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CourseHub - Unlock Your Potential with Online Learning')</title>

    <!-- Bootstrap 5 CSS & FontAwesome 6 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --bg-color: #f8fafc;
            --text-color: #1e293b;
            --text-muted: #64748b;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
        }
        [data-bs-theme="dark"] {
            --bg-color: #0f172a;
            --text-color: #f1f5f9;
            --text-muted: #94a3b8;
            --card-bg: #1e293b;
            --border-color: #334155;
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s ease, color 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .brand-navbar {
            position: fixed;
            top: 0; left: 0; width: 100%;
            height: 85px;
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            z-index: 9999;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        main {
            flex: 1;
            margin-top: 85px; /* لتعويض مساحة الـ Navbar الثابت */
        }
        .card {
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-color) !important;
            font-weight: 800 !important;
        }
        p, .text-muted { color: var(--text-muted) !important; }
        .form-control {
            background-color: var(--bg-color) !important;
            color: var(--text-color) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
        }
        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }
        #themeToggleBtn {
            width: 40px; height: 40px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        #themeToggleBtn:hover {
            background: var(--primary-color);
            color: #ffffff;
            border-color: var(--primary-color);
            transform: rotate(180deg) scale(1.05);
        }
        .hover-dark:hover {
            color: var(--primary-color) !important;
            transition: color 0.2s ease-in-out;
        }
        .footer-link, .social-icon-link {
            color: #9898b0;
            transition: color 0.2s ease-in-out;
        }
        .footer-link:hover { color: #ffffff !important; }
        .social-icon-link:hover { color: var(--primary-color) !important; }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg brand-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                    <i class="fa-solid fa-graduation-cap fs-5"></i>
                </div>
                <span class="fs-4 fw-bold tracking-tight">Course Hub</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-3">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link fw-semibold" href="{{ url('/') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ route('courses.index') }}">Courses</a></li>
                            <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ route('categories.index') }}">Categories</a></li>
                        @elseif(Auth::user()->role === 'teacher')
                            <li class="nav-item"><a class="nav-link fw-semibold" href="{{ url('/') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ route('courses.index') }}">Courses</a></li>
                            <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ route('teacher.students') }}">Students</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link fw-semibold" href="{{ url('/') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ route('courses.index') }}">Courses</a></li>
                            <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ route('categories.index') }}">Categories</a></li>
                        @endif
                    @else
                        <li class="nav-item"><a class="nav-link fw-semibold" href="{{ url('/') }}#home">Home</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ url('/courses') }}">Courses</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ url('/') }}#instructors">Instructors</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ url('/categories') }}">Categories</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold text-muted hover-dark" href="{{ url('/') }}#about">About</a></li>
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <button id="themeToggleBtn" title="Toggle Theme">
                        <i id="themeIcon" class="fa-solid fa-moon"></i>
                    </button>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-primary rounded-pill px-4 fw-bold dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                                    @if(Auth::user()->role === 'admin')
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                                <i class="bi bi-speedometer2 me-2 text-primary"></i> Admin Dashboard
                                            </a>
                                        </li>
                                    @elseif(Auth::user()->role === 'teacher')
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('teacher.dashboard') }}">
                                                <i class="bi bi-person-workspace me-2 text-primary"></i> Teacher Dashboard
                                            </a>
                                        </li>
                                    @else
                                        <!-- روابط الطالب -->
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('student.dashboard') }}">
                                                <i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('student.profile') }}">
                                                <i class="bi bi-person-gear me-2 text-info"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('student.my-courses') }}">
                                                <i class="bi bi-collection-play me-2 text-success"></i> My Courses
                                            </a>
                                        </li>
                                    @endif

                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger border-0 bg-transparent w-100 text-start d-flex align-items-center">
                                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- مكان حقن محتوى كل صفحة فرعية -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light pt-5 pb-4 mt-auto" style="background-color: #161622 !important; border-top: 1px solid rgba(255,255,255,0.08);">
        <div class="container py-4">
            <div class="row g-4 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-graduation-cap fs-5"></i>
                        </div>
                        <span class="fs-4 fw-bold text-white">Course Hub</span>
                    </div>
                    <p class="text-muted small mb-4" style="line-height: 1.8;">
                        Your ultimate learning ecosystem designed to master programming, design, and data science through hands-on projects and real-world execution.
                    </p>
                </div>
                <div class="col-lg-2 col-md-6 col-6">
                    <h5 class="text-white fw-bold fs-6 mb-3 text-uppercase">Quick Links</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="{{ url('/') }}" class="footer-link text-decoration-none">Home</a></li>
                        <li><a href="{{ route('courses.index') }}" class="footer-link text-decoration-none">All Courses</a></li>
                        <li><a href="{{ route('categories.index') }}" class="footer-link text-decoration-none">Categories</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white fw-bold fs-6 mb-3 text-uppercase">Newsletter</h5>
                    <p class="text-muted small mb-3">Subscribe to get the latest courses, tech trends, and exclusive offers.</p>
                    <form action="#" method="POST" class="d-flex flex-column gap-2">
                        @csrf
                        <div class="input-group">
                            <input type="email" class="form-control text-light border-secondary shadow-none" style="background-color: #1e1e2f; border-color: rgba(255,255,255,0.1) !important;" placeholder="Enter your email..." required>
                            <button class="btn btn-primary fw-bold px-4 shadow-sm" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.08);">
            <div class="text-center">
                <p class="text-muted small mb-0">&copy; {{ date('Y') }} <span class="text-white fw-semibold">Course Hub</span>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement;

            const savedTheme = localStorage.getItem('theme') || 'light';
            htmlElement.setAttribute('data-bs-theme', savedTheme);
            updateIcon(savedTheme);

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function () {
                    let currentTheme = htmlElement.getAttribute('data-bs-theme');
                    let newTheme = currentTheme === 'light' ? 'dark' : 'light';
                    htmlElement.setAttribute('data-bs-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                    updateIcon(newTheme);
                });
            }

            function updateIcon(theme) {
                if (!themeIcon) return;
                if (theme === 'dark') {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun', 'text-warning');
                } else {
                    themeIcon.classList.remove('fa-sun', 'text-warning');
                    themeIcon.classList.add('fa-moon');
                }
            }
        });
    </script>
</body>
</html>