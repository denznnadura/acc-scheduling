{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --acc-primary: #1e40af;
            --acc-secondary: #dc2626;
            --acc-accent: #059669;
            --acc-gold: #f59e0b;
            --acc-light-blue: #3b82f6;
            --bg-primary: #fafafa;
            --bg-secondary: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-tertiary: #94a3b8;
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 72px;
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.03);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            letter-spacing: -0.01em;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border-light);
            flex-shrink: 0;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-primary);
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .sidebar-logo:hover {
            opacity: 0.8;
        }

        .logo-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: contain;
            background: var(--bg-primary);
            padding: 6px;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .logo-title {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        .logo-subtitle {
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-transform: uppercase;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar-menu-container {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px;
        }

        .sidebar-menu-container::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu-container::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        .sidebar-menu {
            list-style: none;
        }

        .menu-section-title {
            padding: 16px 12px 8px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-tertiary);
            transition: all 0.3s;
        }

        .sidebar.collapsed .menu-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 2px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 11px 12px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
            gap: 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            position: relative;
        }

        .sidebar-menu li a:hover {
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .sidebar-menu li a.active {
            background: var(--acc-primary);
            color: white;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        .sidebar-menu li a i {
            font-size: 20px;
            min-width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-text {
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .sidebar-menu li a {
            justify-content: center;
            padding: 11px;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--border-light);
            flex-shrink: 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .sidebar-user:hover {
            background: var(--bg-primary);
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--acc-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: white;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 11px;
            color: var(--text-tertiary);
        }

        .sidebar.collapsed .sidebar-user-info {
            display: none;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-width));
        }

        .sidebar.collapsed~.main-content {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }

        .navbar {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-light);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1040;
            backdrop-filter: blur(8px);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
        }

        .sidebar-toggle-btn {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--text-secondary);
        }

        .sidebar-toggle-btn:hover {
            background: var(--bg-secondary);
            border-color: var(--acc-primary);
            color: var(--acc-primary);
        }

        .sidebar-toggle-btn i {
            font-size: 20px;
        }

        .mobile-menu-btn {
            display: none;
        }

        .breadcrumb-container {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
        }

        .page-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--text-tertiary);
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: '/';
            margin-right: 6px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification-btn {
            position: relative;
            background: transparent;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s;
        }

        .notification-btn:hover {
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .notification-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            background: var(--acc-secondary);
            color: white;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 5px;
            border-radius: 10px;
            min-width: 16px;
            text-align: center;
        }

        .dropdown {
            position: relative;
        }

        .user-dropdown-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: 1px solid var(--border-color);
            padding: 6px 12px 6px 6px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--text-primary);
        }

        .user-dropdown-btn:hover {
            background: var(--bg-primary);
            border-color: var(--acc-primary);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: var(--acc-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 12px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            line-height: 1;
        }

        .user-role {
            font-size: 11px;
            color: var(--text-tertiary);
            line-height: 1;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 200px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            border-radius: 10px;
            padding: 6px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 2000;
        }

        .dropdown.show .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border-light);
            margin: 6px 0;
        }

        .dropdown-item {
            padding: 8px 12px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .dropdown-item:hover {
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .dropdown-item i {
            font-size: 18px;
        }

        .page-content {
            flex: 1;
            padding: 24px;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            border: 1px solid;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-success {
            background: #f0fdf4;
            border-color: #86efac;
            color: #166534;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: #fca5a5;
            color: #991b1b;
        }

        .alert i {
            font-size: 20px;
            flex-shrink: 0;
        }

        .btn-close {
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: inherit;
            opacity: 0.6;
            margin-left: auto;
            padding: 4px;
            transition: opacity 0.2s;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .page-loader {
            position: fixed;
            inset: 0;
            background: var(--bg-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s;
        }

        .page-loader.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loader-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--border-color);
            border-top-color: var(--acc-primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1045;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .mobile-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .sidebar-toggle-btn {
                display: none !important;
            }

            .mobile-menu-btn {
                display: flex;
                background: var(--bg-primary);
                border: 1px solid var(--border-color);
                width: 36px;
                height: 36px;
                border-radius: 8px;
                align-items: center;
                justify-content: center;
                color: var(--text-secondary);
            }

            .mobile-menu-btn:active {
                background: var(--bg-secondary);
            }

            .breadcrumb-container {
                display: none;
            }

            .user-info {
                display: none !important;
            }

            .page-content {
                padding: 16px;
            }

            .mobile-overlay {
                display: block;
            }

            .navbar {
                padding: 12px 16px;
            }
        }

        @media (max-width: 480px) {
            .user-dropdown-btn {
                padding: 6px;
            }

            .dropdown-menu {
                min-width: 180px;
            }
        }

        @media print {
            .sidebar,
            .navbar,
            .mobile-overlay,
            .alert {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .page-content {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="page-loader" id="pageLoader">
        <div class="loader-spinner"></div>
    </div>

    <div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <img src="{{ asset('assets/logo.png') }}" alt="ACC Logo" class="logo-image">
                <div class="logo-text">
                    <span class="logo-title">ACC SCHEDULING</span>
                    <span class="logo-subtitle">Pro Deo Et Patria</span>
                </div>
            </a>
        </div>

        <div class="sidebar-menu-container">
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class='bx bx-grid-alt'></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()->isAdmin())
                    <div class="menu-section-title">Academic</div>
                    <li>
                        <a href="{{ route('schedules.index') }}"
                            class="{{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                            <i class='bx bx-calendar'></i>
                            <span class="menu-text">Schedules</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.enrollments.index') }}"
                            class="{{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
                            <i class='bx bx-user-check'></i>
                            <span class="menu-text">Enrollments</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sections.index') }}"
                            class="{{ request()->routeIs('sections.*') ? 'active' : '' }}">
                            <i class='bx bx-group'></i>
                            <span class="menu-text">Sections</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('courses.index') }}"
                            class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">
                            <i class='bx bx-book'></i>
                            <span class="menu-text">Courses</span>
                        </a>
                    </li>

                    <div class="menu-section-title">Users</div>
                    <li>
                        <a href="{{ route('faculty.index') }}"
                            class="{{ request()->routeIs('faculty.*') ? 'active' : '' }}">
                            <i class='bx bx-user-pin'></i>
                            <span class="menu-text">Faculty</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('students.index') }}"
                            class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
                            <i class='bx bx-user'></i>
                            <span class="menu-text">Students</span>
                        </a>
                    </li>

                    <div class="menu-section-title">Resources</div>
                    <li>
                        <a href="{{ route('rooms.index') }}"
                            class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                            <i class='bx bx-door-open'></i>
                            <span class="menu-text">Rooms</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('departments.index') }}"
                            class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">
                            <i class='bx bx-briefcase'></i>
                            <span class="menu-text">Departments</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('programs.index') }}"
                            class="{{ request()->routeIs('programs.*') ? 'active' : '' }}">
                            <i class='bx bx-book-open'></i>
                            <span class="menu-text">Programs</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('semesters.index') }}"
                            class="{{ request()->routeIs('semesters.*') ? 'active' : '' }}">
                            <i class='bx bx-time'></i>
                            <span class="menu-text">Semesters</span>
                        </a>
                    </li>

                    <div class="menu-section-title">Analytics</div>
                    <li>
                        <a href="{{ route('reports.index') }}"
                            class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class='bx bx-bar-chart-alt-2'></i>
                            <span class="menu-text">Reports</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->isFaculty())
                    <div class="menu-section-title">My Schedule</div>
                    <li>
                        <a href="{{ route('schedules.index') }}"
                            class="{{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                            <i class='bx bx-calendar'></i>
                            <span class="menu-text">Class Schedule</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->isStudent())
                    <div class="menu-section-title">My Classes</div>
                    <li>
                        <a href="{{ route('enrollments.index') }}"
                            class="{{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
                            <i class='bx bx-calendar-check'></i>
                            <span class="menu-text">My Enrollments</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">
                        {{ is_object(auth()->user()->role) ? auth()->user()->role->name : auth()->user()->role }}
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-content">
        <nav class="navbar">
            <div class="navbar-brand">
                <button class="sidebar-toggle-btn" onclick="toggleSidebar()" title="Toggle Menu">
                    <i class='bx bx-menu'></i>
                </button>

                <button class="mobile-menu-btn" onclick="toggleMobileSidebar()">
                    <i class='bx bx-menu'></i>
                </button>

                <div class="breadcrumb-container">
                    <h1 class="page-title">{{ $pageTitle ?? 'Dashboard' }}</h1>
                    <nav class="breadcrumb">
                        <span class="breadcrumb-item">Home</span>
                        @if (isset($breadcrumb))
                            <span class="breadcrumb-item">{{ $breadcrumb }}</span>
                        @endif
                    </nav>
                </div>
            </div>

            <div class="user-menu">
                <div class="dropdown" id="userDropdown">
                    <button class="user-dropdown-btn" onclick="toggleDropdown()">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-role">
                                {{ is_object(auth()->user()->role) ? auth()->user()->role->name : auth()->user()->role }}
                            </span>
                        </div>
                        <i class='bx bx-chevron-down' style="font-size: 16px;"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class='bx bx-user-circle'></i>
                                My Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class='bx bx-log-out'></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="page-content">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class='bx bx-check-circle'></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" onclick="this.parentElement.remove()">
                        <i class='bx bx-x'></i>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class='bx bx-error-circle'></i>
                    <div>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" onclick="this.parentElement.remove()">
                        <i class='bx bx-x'></i>
                    </button>
                </div>
            @endif
           


            {{ $slot }}
       </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Page Loader Logic
        window.addEventListener('load', () => {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                setTimeout(() => loader.classList.add('hidden'), 300);
            }
        });

        // 2. Sidebar Toggle (Desktop)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        }

        // 3. Mobile Sidebar Logic
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            }
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            if (sidebar) sidebar.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // 4. User Dropdown Logic
        function toggleDropdown(event) {
            if (event) event.stopPropagation(); // Prevents immediate closing from the document listener
            const dropdown = document.getElementById('userDropdown');
            if (dropdown) dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('userDropdown');
            // Fixed: Check if dropdown exists and if the click was outside of it
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // 5. Responsive Adjustments
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) closeMobileSidebar();
        });

        // 6. Persistence & Delete Confirmation
        document.addEventListener('DOMContentLoaded', () => {
            // Restore Sidebar State
            const sidebar = document.getElementById('sidebar');
            if (sidebar && window.innerWidth > 768 && localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
            }

            // Global Delete Confirmation (SweetAlert2)
            document.body.addEventListener('submit', (e) => {
                if (e.target.classList.contains('delete-form')) {
                    e.preventDefault();
                    const form = e.target;
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                }
            });

            // 7. Auto-hide Alerts
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500); // Smooth removal
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>