<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Madil')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/dashboard.css') }}">
    <style>
        /* Base Styles */
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Navbar Styles */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.18) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            padding-right: 4rem !important;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
        }

        .navbar-nav .nav-link {
            color: #333;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
            border-radius: 8px;
            margin: 0.25rem;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary-color);
        }

        .nav-buttons .btn-link {
            padding: 0.5rem;
            color: #333;
            transition: all 0.3s;
            border-radius: 8px;
            position: relative;
        }

        .nav-buttons .btn-link:hover {
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary-color);
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .sidebar-user-info {
            padding: 1.5rem 1rem;
            text-align: center;
            background: rgba(108, 92, 231, 0.05);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 1rem;
            border: 3px solid var(--primary-color);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .nav-link {
            padding: 0.75rem 1rem;
            color: #333;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            margin: 0.25rem 0.75rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary-color);
        }

        .sidebar-menu .nav-link i {
            width: 24px;
            margin-left: 0.75rem;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-right: 280px;
            padding: 1rem;
            padding-top: 76px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .sidebar {
                width: 250px;
            }
            .main-content {
                margin-right: 250px;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-right: 0;
            }
            .sidebar-toggle {
                display: block !important;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand img {
                height: 40px;
            }
            .nav-buttons {
                margin-top: 1rem;
                justify-content: center !important;
            }
            .nav-buttons .btn-link {
                padding: 0.4rem;
            }
            .sidebar {
                width: 100%;
                max-width: 300px;
            }
            .main-content {
                padding: 0.75rem;
                padding-top: 70px;
            }
            .sidebar-menu .nav-link {
                padding: 0.6rem 0.75rem;
                margin: 0.25rem 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                padding: 0.5rem 0;
            }
            .navbar-brand img {
                height: 35px;
            }
            .nav-buttons .btn-link {
                padding: 0.3rem;
                font-size: 0.9rem;
            }
            .sidebar-user-info {
                padding: 1rem;
            }
            .user-avatar {
                width: 60px;
                height: 60px;
            }
            .sidebar-menu .nav-link {
                font-size: 0.9rem;
            }
            .main-content {
                padding: 0.5rem;
                padding-top: 65px;
            }
            .glass-navbar {
                padding-right: 3.5rem !important;
            }
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            display: block;
            position: fixed;
            right: 1rem;
            top: 1rem;
            z-index: 1050;
            background: var(--primary-color);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .sidebar-toggle:hover {
            background: var(--secondary-color);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .sidebar-toggle:active {
            transform: scale(0.95);
        }

        .sidebar-toggle i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .sidebar.show + .main-content .sidebar-toggle i {
            transform: rotate(180deg);
        }

        /* Notification Dropdown */
        .notification-dropdown {
            width: 300px;
            max-width: 90vw;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 0;
            overflow: hidden;
        }

        @media (max-width: 576px) {
            .notification-dropdown {
                width: 280px;
                margin-top: 0.5rem;
            }
        }

        /* Badge Styles */
        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 500;
        }

        /* Button Styles */
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Scrollbar Styles */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(108, 92, 231, 0.5);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(108, 92, 231, 0.7);
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle" type="button" aria-label="Toggle Sidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg glass-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Madil" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="fas fa-home ms-1"></i>الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="/products"><i class="fas fa-tshirt ms-1"></i>المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="/dashboard"><i class="fas fa-user ms-1"></i>حسابي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('appointments*') ? 'active' : '' }}" href="{{ route('appointments.index') }}"><i class="fas fa-calendar-alt ms-1"></i>المواعيد</a>
                    </li>
                </ul>
                <div class="nav-buttons d-flex align-items-center">
                    <a href="/cart" class="btn btn-link position-relative me-3">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        @if($stats['cart_items_count'] > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $stats['cart_items_count'] }}
                        </span>
                        @endif
                    </a>
                    <div class="dropdown me-3">
                        <button class="btn btn-link position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fa-lg"></i>
                            @if($stats['unread_notifications'] > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $stats['unread_notifications'] }}
                            </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown">
                            @forelse($recent_notifications as $notification)
                            <li>
                                <a class="dropdown-item {{ !$notification->read_at ? 'unread' : '' }}" href="#">
                                    <i class="fas {{ $notification->icon }} me-2"></i>
                                    <div class="notification-content">
                                        <p class="mb-1">{{ $notification->data['message'] }}</p>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                            @empty
                            <li>
                                <div class="dropdown-item text-center">لا توجد إشعارات</div>
                            </li>
                            @endforelse
                            @if(count($recent_notifications) > 0)
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-center" href="/notifications">عرض كل الإشعارات</a></li>
                            @endif
                        </ul>
                    </div>
                    <a href="{{ route('logout') }}" class="btn btn-outline-primary"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt ms-1"></i>تسجيل الخروج
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="/">
                <!-- <img src="{{ asset('images/logo.png') }}" alt="Madil" height="40"> -->
            </a>
        </div>
        <div class="sidebar-user-info">
            <!-- <img src="{{ asset('images/default-avatar.png') }}" alt="{{ Auth::user()->name }}" class="user-avatar"> -->
            <h5 class="mb-2">{{ Auth::user()->name }}</h5>
            <span class="badge bg-primary">{{ Auth::user()->role === 'admin' ? 'مدير' : 'عميل' }}</span>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="fas fa-home"></i>
                        لوحة التحكم
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="/products">
                        <i class="fas fa-shopping-bag"></i>
                        المنتجات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('orders*') ? 'active' : '' }}" href="/orders">
                        <i class="fas fa-shopping-bag"></i>
                        الطلبات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('appointments*') ? 'active' : '' }}" href="/appointments">
                        <i class="fas fa-calendar-check"></i>
                        المواعيد
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('cart*') ? 'active' : '' }}" href="/cart">
                        <i class="fas fa-shopping-cart"></i>
                        السلة
                        @if($stats['cart_items_count'] > 0)
                        <span class="badge bg-danger ms-auto">{{ $stats['cart_items_count'] }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('notifications*') ? 'active' : '' }}" href="/notifications">
                        <i class="fas fa-bell"></i>
                        الإشعارات
                        @if($stats['unread_notifications'] > 0)
                        <span class="badge bg-danger ms-auto">{{ $stats['unread_notifications'] }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profile*') ? 'active' : '' }}" href="/user/profile">
                        <i class="fas fa-user"></i>
                        الملف الشخصي
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        تسجيل الخروج
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // تهيئة CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add Sidebar Toggle Functionality
        $(document).ready(function() {
            $('.sidebar-toggle').on('click', function() {
                $('.sidebar').toggleClass('show');
            });

            // Close sidebar when clicking outside on mobile
            $(document).on('click', function(e) {
                if ($(window).width() < 992) {
                    if (!$(e.target).closest('.sidebar').length && !$(e.target).closest('.sidebar-toggle').length) {
                        $('.sidebar').removeClass('show');
                    }
                }
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
