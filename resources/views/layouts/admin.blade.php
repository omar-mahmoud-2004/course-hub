<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - CourseHub')</title>

    <!-- Bootstrap المحلي -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
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
            transition: background-color 0.25s ease;
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