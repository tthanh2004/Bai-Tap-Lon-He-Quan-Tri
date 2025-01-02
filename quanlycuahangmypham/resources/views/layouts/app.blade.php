{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyApp')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        /* Reset and Base Styles */
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            transition: margin-left 0.3s ease;
            position: relative;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        /* Sidebar Styles */
        .app-sidebar {
            width: 250px;
            min-height: 100vh;
            transition: transform 0.3s ease, width 0.3s ease;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            border-right: 1px solid #dee2e6; /* Vertical divider */
            background-color: #f8f9fa;
            z-index: 1040; /* Below navbar's z-index */
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        /* Hidden state for sidebar */
        .app-sidebar.collapsed {
            transform: translateX(-100%);
            width: 0;
            border-right: none;
        }

        /* Sidebar Brand */
        .sidebar-brand {
            padding: 1rem;
            text-align: center;
            font-size: 1.5rem;
            background-color: #f8f9fa;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            width: 100%;
            height: 60px; /* Same height as header */
            top: 0;
            left: 0;
        }
        /* Hide sidebar-brand when collapsed */
        .app-sidebar.collapsed .sidebar-brand {
            opacity: 0;
            visibility: hidden;
        }

        /* Sidebar Wrapper */
        .sidebar-wrapper {
            transition: padding 0.3s ease;
            position: absolute;
            top: 60px; /* Height of the header */
            width: 100%;
            bottom: 0;
            overflow-y: auto;
            padding-top: 1rem;
        }
        /* Adjust sidebar-wrapper when collapsed */
        .app-sidebar.collapsed .sidebar-wrapper {
            padding: 1rem 0.5rem;
        }

        /* Navigation Links */
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            transition: padding 0.3s ease;
            color: #495057;
            text-decoration: none;
        }
        /* Hide labels when sidebar is collapsed */
        .app-sidebar.collapsed .nav-link span {
            display: none;
        }
        /* Icon styling */
        .nav-link i {
            min-width: 20px;
            text-align: center;
            margin-right: 1rem;
        }
        /* Active link styling */
        .nav-link.active {
            background-color: #e9ecef;
            font-weight: bold;
        }

        /* Navbar (app-header) Styles */
        .app-header {
            transition: margin-left 0.3s ease, width 0.3s ease;
            width: calc(100% - 250px); /* Adjust width when sidebar is expanded */
            margin-left: 250px; /* Align with sidebar width */
            height: 60px; /* Fixed height */
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1050; /* Above sidebar */
        }
        body.sidebar-collapsed .app-header {
            margin-left: 0;
            width: 100%; /* Full width when sidebar is collapsed */
        }

        /* Horizontal Divider */
        .horizontal-divider {
            position: absolute;
            top: 60px; /* Below header */
            left: 250px; /* Align with sidebar width */
            width: calc(100% - 250px);
            height: 1px;
            background-color: #dee2e6;
            transition: left 0.3s ease, width 0.3s ease;
            z-index: 999;
        }
        body.sidebar-collapsed .horizontal-divider {
            left: 0;
            width: 100%; /* Full width when sidebar is collapsed */
        }

        /* Main Content Area */
        .app-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease, width 0.3s ease;
            position: relative;
            margin-left: 250px; /* Same as sidebar width */
            margin-top: 60px; /* Height of the navbar */
            width: calc(100% - 250px);
        }
        body.sidebar-collapsed .app-wrapper {
            margin-left: 0;
            width: 100%;
        }

        /* Responsive: Adjustments for Small Screens */
        @media (max-width: 992px) {
            /* Sidebar */
            .app-sidebar {
                transform: translateX(-250px); /* Hide sidebar by default */
                width: 250px;
            }
            .app-sidebar.show {
                transform: translateX(0);
            }
            .app-sidebar.collapsed {
                transform: translateX(-250px);
                width: 250px; /* Ensure width remains for off-canvas */
            }

            /* Navbar */
            .app-header {
                width: 100%;
                margin-left: 0;
            }
            body.sidebar-collapsed .app-wrapper {
                margin-left: 0;
                width: 100%;
            }
            body:not(.sidebar-collapsed) .app-wrapper {
                /* No margin-left on small screens when sidebar is shown */
            }

            /* Horizontal Divider */
            .horizontal-divider {
                left: 0;
                width: 100%;
            }
            body.sidebar-collapsed .horizontal-divider {
                left: 0;
                width: 100%;
            }

            /* Overlay (optional) */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1030; /* Below sidebar's z-index */
            }
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>

    @stack('styles') <!-- Additional styles from child views -->
</head>

<body class="bg-body-tertiary @if(!Request::is('/')) sidebar-collapsed @endif">
    @unless (Request::is('/'))
        <!-- Sidebar -->
        <aside class="app-sidebar bg-body-secondary shadow collapsed" id="sidebar">
            <!-- Sidebar Content -->
            <div class="sidebar-brand">
                <a href="{{ url('/dashboard') }}" class="text-decoration-none text-dark d-flex align-items-center">
                    <i class="fas fa-home me-2"></i> <span>MyApp</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav flex-column">
                    <!-- Menu Items -->
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                            <i class="fas fa-user me-2"></i> <span>Profile</span>
                        </a>
                    </li>
                    <!-- Thêm các menu item khác tương tự -->
                </ul>
            </div>
        </aside>

        <!-- Overlay for Small Screens -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Navbar -->
        @if (Route::has('login'))
            <nav class="app-header navbar navbar-expand-lg navbar-light bg-white fixed-top shadow">
                <div class="container-fluid">
                    <!-- Sidebar Toggle Button -->
                    <button class="btn btn-primary me-2" id="sidebarToggle" aria-label="Toggle Sidebar" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="{{ url('/dashboard') }}">MyApp</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Navbar Content -->
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            @auth
                                <!-- User Dropdown -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if (Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle me-2" width="30" height="30">
                                        @else
                                            <i class="fas fa-user-circle me-2"></i>
                                        @endif
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                                <i class="fas fa-user me-2"></i> Profile
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link d-flex align-items-center">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login
                                    </a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a href="{{ route('register') }}" class="nav-link d-flex align-items-center">
                                            <i class="fas fa-user-plus me-2"></i> Register
                                        </a>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        @endif

        <!-- Horizontal Divider -->
        <div class="horizontal-divider"></div>

        <!-- Main Content Area -->
        <div class="app-wrapper" id="appWrapper">
            <main class="flex-grow p-4">
                @yield('content')
            </main>
        </div>
    @else
        <!-- Welcome Page Content -->
        @yield('welcome')
    @endunless

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Font Awesome JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-pzVZl0k4k+Mz9uYIsV6g+Z+j5eGkRXi6W+lqW5Dk+zYXZlNjQ/1FJ5aBJbVxkYSmzdnqI0OQdGL/7PQ6T6nqBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Custom JS to Control Sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const body = document.body;

            sidebarToggle.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent event bubbling

                // Toggle sidebar classes
                sidebar.classList.toggle('collapsed');
                sidebar.classList.toggle('show'); // For responsive behavior
                body.classList.toggle('sidebar-collapsed');

                // Toggle overlay visibility on small screens
                if (window.innerWidth <= 992) {
                    sidebarOverlay.classList.toggle('show');
                }

                // Update aria-expanded attribute
                const isCollapsed = body.classList.contains('sidebar-collapsed');
                sidebarToggle.setAttribute('aria-expanded', !isCollapsed);
            });

            // Close sidebar when clicking on the overlay on small screens
            sidebarOverlay.addEventListener('click', function () {
                if (window.innerWidth <= 992 && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                    sidebarOverlay.classList.remove('show');
                    sidebarToggle.setAttribute('aria-expanded', false);
                }
            });

            // Handle ESC key to close sidebar on small screens
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    const isSmallScreen = window.innerWidth <= 992;
                    if (isSmallScreen && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        sidebar.classList.add('collapsed');
                        body.classList.add('sidebar-collapsed');
                        sidebarOverlay.classList.remove('show');
                        sidebarToggle.setAttribute('aria-expanded', false);
                    }
                }
            });

            // Optional: Handle window resize to reset sidebar state
            window.addEventListener('resize', function () {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
