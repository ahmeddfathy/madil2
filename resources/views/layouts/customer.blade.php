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
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
            border-left: 1px solid rgba(255, 255, 255, 0.18);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-user-info {
            padding: 20px;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
            object-fit: cover;
            border: 3px solid rgba(108, 92, 231, 0.8);
            box-shadow: 0 0 15px rgba(108, 92, 231, 0.3);
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu .nav-link {
            padding: 12px 20px;
            color: #333;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            margin: 2px 10px;
            border-radius: 10px;
        }

        .sidebar-menu .nav-link:hover {
            background: rgba(255, 255, 255, 0.3);
            color: var(--primary-color);
            transform: translateX(-5px);
        }

        .sidebar-menu .nav-link.active {
            background: rgba(108, 92, 231, 0.15);
            color: var(--primary-color);
            border-right: 4px solid var(--primary-color);
        }

        .sidebar-menu .nav-link i {
            margin-left: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-right: 280px;
            padding: 20px;
            padding-top: 76px;
            transition: all 0.3s ease;
        }

        /* Mobile Styles */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(280px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
                padding-top: 76px;
            }

            .sidebar-toggle {
                display: block !important;
            }
        }

        .sidebar-toggle {
            display: none;
            position: fixed;
            right: 20px;
            top: 20px;
            z-index: 1001;
            background: rgba(108, 92, 231, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Navbar Styles */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.18) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .navbar-nav .nav-link {
            color: #333;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
            border-radius: 8px;
            margin: 0 5px;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link.active {
            background: rgba(108, 92, 231, 0.15);
            color: var(--primary-color);
        }

        .nav-buttons .btn-link {
            color: #333;
            text-decoration: none;
            padding: 0.5rem;
            transition: all 0.3s;
            border-radius: 8px;
            margin: 0 5px;
        }

        .nav-buttons .btn-link:hover {
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .notification-dropdown {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            border-radius: 15px;
            min-width: 300px;
            padding: 0;
            overflow: hidden;
        }

        .notification-dropdown .dropdown-item {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
            transition: all 0.3s;
        }

        .notification-dropdown .dropdown-item:hover {
            background: rgba(108, 92, 231, 0.1);
        }

        .notification-dropdown .dropdown-item.unread {
            background: rgba(108, 92, 231, 0.05);
        }

        .notification-dropdown .notification-content {
            margin-right: 2rem;
        }
    </style>
    @yield('styles')
</head>

<body>
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

    <!-- Sidebar Toggle Button (Mobile) -->
    <button class="sidebar-toggle" type="button">
        <i class="fas fa-bars"></i>
    </button>

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
