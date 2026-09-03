<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - CourseHub')</title>

    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>

    <!-- Bootstrap المحلي -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bs-body-bg: #f8fafc;
            --bs-body-color: #1e293b;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #0f172a !important;
            --bs-body-color: #f1f5f9 !important;
            --bs-border-color: #334155 !important;
            --card-bg: #1e293b !important;
            --card-border: #334155 !important;
        }

        body {
            background-color: var(--bs-body-bg, #f8fafc);
            color: var(--bs-body-color, #212529);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        main {
            flex: 1;
        }

        .admin-navbar {
            background-color: var(--bs-body-bg) !important;
            border-bottom: 1px solid var(--bs-border-color) !important;
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        .footer-dark {
            background-color: #0f172a;
            color: #94a3b8;
        }

        .icon-circle {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.6rem;
        }

        /* زر التحويل */
        #themeToggleBtn {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        #themeToggleBtn:hover {
            transform: scale(1.08);
        }

        /* Dark Mode Overrides */
        [data-bs-theme="dark"] body {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }

        [data-bs-theme="dark"] .admin-navbar {
            background-color: #1e293b !important;
            border-bottom-color: #334155 !important;
        }

        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .bg-white {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            border: 1px solid #334155 !important;
        }

        [data-bs-theme="dark"] .text-dark {
            color: #f1f5f9 !important;
        }

        [data-bs-theme="dark"] .text-secondary,
        [data-bs-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] .table {
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .table thead,
        [data-bs-theme="dark"] .table-light,
        [data-bs-theme="dark"] .table-light th,
        [data-bs-theme="dark"] .table > :not(caption) > * > * {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .table-hover > tbody > tr:hover > * {
            background-color: #27354f !important;
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
        }

        [data-bs-theme="dark"] .form-control::placeholder {
            color: #64748b !important;
        }

        [data-bs-theme="dark"] .modal-content {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .modal-header,
        [data-bs-theme="dark"] .modal-footer {
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .dropdown-item {
            color: #f1f5f9 !important;
        }

        [data-bs-theme="dark"] .dropdown-item:hover {
            background-color: #27354f !important;
        }

        [data-bs-theme="dark"] .pagination .page-link {
            background-color: #1e293b;
            border-color: #334155;
            color: #94a3b8;
        }

        [data-bs-theme="dark"] .pagination .page-item.active .page-link {
            background-color: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }

        [data-bs-theme="dark"] .footer-dark {
            background-color: #0b1120 !important;
            border-top: 1px solid #1e293b;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg admin-navbar py-3 sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <span class="text-primary"><i class="bi bi-mortarboard-fill"></i></span> CourseHub
            </a>

            <!-- روابط لوحة الأدمن -->
            <div class="d-none d-md-flex align-items-center gap-3">
                <a href="{{ url('/') }}" class="nav-link text-body-secondary fw-semibold">Home</a>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'text-primary fw-bold' : 'text-body-secondary fw-semibold' }}">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'text-primary fw-bold' : 'text-body-secondary fw-semibold' }}">
                    <i class="bi bi-people me-1"></i> Users
                </a>

                <a href="{{ route('admin.courses.index') }}" class="nav-link {{ request()->routeIs('admin.courses.*') ? 'text-primary fw-bold' : 'text-body-secondary fw-semibold' }}">
                    <i class="bi bi-book me-1"></i> Courses
                </a>

                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'text-primary fw-bold' : 'text-body-secondary fw-semibold' }}">
                    <i class="bi bi-tags me-1"></i> Categories
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'text-primary fw-bold' : 'text-body-secondary fw-semibold' }}">
                    <i class="bi bi-star me-1"></i> Reviews
                </a>
            </div>

            <!-- الزر وحساب الأدمن -->
            <div class="d-flex align-items-center gap-3">
                <!-- Dark Mode Toggle Button (باستخدام Bootstrap Icons) -->
                <button class="btn btn-sm btn-outline-secondary rounded-circle" id="themeToggleBtn" type="button" title="Toggle Dark/Light Mode">
                    <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                </button>

                <span class="fw-semibold text-body-secondary small d-none d-sm-inline">Hi, {{ auth()->user()->name }}</span>
                
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-primary px-3 rounded-3 btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Dark Footer -->
    <footer class="footer-dark py-5 mt-5">
        <div class="container">
            <div class="row g-4 justify-content-between mb-4">
                <div class="col-lg-4">
                    <h5 class="text-white fw-bold d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-mortarboard-fill text-primary"></i> CourseHub
                    </h5>
                    <p class="small text-secondary mb-0">
                        Learn new skills, improve your knowledge, and build your future with online courses.
                    </p>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="text-white fw-semibold mb-3">Platform</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ url('/') }}" class="text-secondary text-decoration-none">Home</a></li>
                        <li><a href="{{ route('admin.courses.index') }}" class="text-secondary text-decoration-none">Courses</a></li>
                        <li><a href="{{ route('admin.categories.index') }}" class="text-secondary text-decoration-none">Categories</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="text-white fw-semibold mb-3">Account</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="p-0 text-secondary bg-transparent border-0 text-decoration-none">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <p class="text-center small text-secondary mb-0">© 2026 CourseHub. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS المحلي -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield('scripts')

    <script>
        // قراءة الثيم وتطبيقه فوراً
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            updateToggleIcon(savedTheme);
        })();

        const toggleBtn = document.getElementById('themeToggleBtn');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateToggleIcon(newTheme);
            });
        }

        function updateToggleIcon(theme) {
            const icon = document.getElementById('themeIcon');
            if (icon) {
                if (theme === 'dark') {
                    icon.className = 'bi bi-sun-fill text-warning';
                } else {
                    icon.className = 'bi bi-moon-stars-fill';
                }
            }
        }
    </script>
</body>
</html>