{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Guru') - TeacherApp</title>
    
    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    @stack('styles')
    
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.18);
            --backdrop-blur: 12px;
            --primary-color: #2563eb;
            --gradient-start: #3b82f6;
            --gradient-end: #1d4ed8;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --bg-primary: #f1f5f9;
            --card-bg: #ffffff;
        }

        [data-bs-theme="dark"] {
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --primary-color: #3b82f6;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --bg-primary: #0f172a;
            --card-bg: #1e293b;
            --gradient-start: #3b82f6;
            --gradient-end: #2563eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: background 0.3s ease;
        }

        /* Glassmorphism Navbar */
        .navbar-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(var(--backdrop-blur));
            -webkit-backdrop-filter: blur(var(--backdrop-blur));
            border-bottom: 1px solid var(--glass-border);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 1.25rem;
        }

        .navbar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Glassmorphism Sidebar */
        .sidebar {
            position: fixed;
            left: -280px;
            top: 0;
            width: 280px;
            height: 100vh;
            background: var(--glass-bg);
            backdrop-filter: blur(var(--backdrop-blur));
            -webkit-backdrop-filter: blur(var(--backdrop-blur));
            border-right: 1px solid var(--glass-border);
            transition: left 0.3s ease;
            z-index: 1050;
            overflow-y: auto;
            padding-top: 70px;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1040;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 12px;
            margin: 0 10px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu i {
            font-size: 1.2rem;
            margin-right: 15px;
            width: 24px;
        }

        /* Main Content */
        .main-content {
            padding-top: 80px;
            padding-bottom: 80px;
            min-height: 100vh;
        }

        /* Card Styles */
        .card-glass {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid var(--glass-border);
        }

        .card-glass:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--glass-bg);
            backdrop-filter: blur(var(--backdrop-blur));
            -webkit-backdrop-filter: blur(var(--backdrop-blur));
            border-top: 1px solid var(--glass-border);
            padding: 10px 0;
            z-index: 1000;
        }

        .bottom-nav-item {
            text-align: center;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .bottom-nav-item i {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 5px;
        }

        .bottom-nav-item span {
            font-size: 0.75rem;
        }

        .bottom-nav-item.active,
        .bottom-nav-item:hover {
            color: var(--primary-color);
        }

        /* Theme Toggle */
        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
        }

        /* Notification Badge */
        .notification-badge {
            position: relative;
        }

        .notification-badge .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 0.7rem;
        }

        /* Notification Panel */
        .notification-panel {
            position: fixed;
            right: -380px;
            top: 0;
            width: 380px;
            max-width: 90vw;
            height: 100vh;
            background: var(--glass-bg);
            backdrop-filter: blur(var(--backdrop-blur));
            -webkit-backdrop-filter: blur(var(--backdrop-blur));
            border-left: 1px solid var(--glass-border);
            transition: right 0.3s ease;
            z-index: 1060;
            overflow-y: auto;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.15);
        }

        .notification-panel.active {
            right: 0;
        }

        .notification-panel-header {
            position: sticky;
            top: 0;
            background: var(--glass-bg);
            backdrop-filter: blur(var(--backdrop-blur));
            padding: 20px;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .notification-panel-header h5 {
            margin: 0;
            font-weight: 700;
        }

        .notification-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.1);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notification-close:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: scale(1.1);
        }

        .notification-tabs {
            display: flex;
            padding: 15px 20px;
            gap: 10px;
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 77px;
            background: var(--glass-bg);
            backdrop-filter: blur(var(--backdrop-blur));
            z-index: 9;
        }

        .notification-tab {
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .notification-tab:hover {
            background: rgba(37, 99, 235, 0.1);
        }

        .notification-tab.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .notification-list {
            padding: 10px;
        }

        .notification-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 10px;
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            transform: translateX(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .notification-item.unread {
            background: rgba(37, 99, 235, 0.05);
            border-left: 3px solid var(--primary-color);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
        }

        .notification-icon.info {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
        }

        .notification-icon.success {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .notification-icon.warning {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
        }

        .notification-icon.danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-primary);
        }

        .notification-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 5px;
        }

        .notification-time {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .notification-actions {
            padding: 15px 20px;
            border-top: 1px solid var(--glass-border);
            position: sticky;
            bottom: 0;
            background: var(--glass-bg);
            backdrop-filter: blur(var(--backdrop-blur));
        }

        .mark-all-read {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mark-all-read:hover {
            background: var(--gradient-end);
            transform: translateY(-2px);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gradient-end);
        }

        @media (min-width: 768px) {
            .bottom-nav {
                display: none;
            }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-glass">
        <div class="container-fluid">
            <button class="btn" id="menuToggle">
                <i class="bi bi-list fs-4"></i>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                {{ config('app.name', 'TeacherApp') }}
            </a>
            <div class="d-flex align-items-center gap-3">
                <button class="theme-toggle" id="themeToggle">
                    <i class="bi bi-sun-fill fs-5" id="themeIcon"></i>
                </button>
                <div class="notification-badge">
                    <i class="bi bi-bell fs-5"></i>
                    @if(isset($notificationCount) && $notificationCount > 0)
                        <span class="badge">{{ $notificationCount > 9 ? '9+' : $notificationCount }}</span>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Daftar Siswa</span>
                </a>
            </li>
            <li>
                <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Kehadiran</span>
                </a>
            </li>
            <li>
                <a href="{{ route('learning.index') }}" class="{{ request()->routeIs('learning.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Pembelajaran</span>
                </a>
            </li>
            <li>
                <a href="{{ route('grades.index') }}" class="{{ request()->routeIs('grades.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data-fill"></i>
                    <span>Nilai & Rapor</span>
                </a>
            </li>
            <li>
                <a href="{{ route('messages.index') }}" class="{{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots-fill"></i>
                    <span>Komunikasi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('materials.index') }}" class="{{ request()->routeIs('materials.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span>Materi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('assignments.index') }}" class="{{ request()->routeIs('assignments.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check-fill"></i>
                    <span>Tugas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </aside>

    {{-- Main Content --}}
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Bottom Navigation --}}
    <nav class="bottom-nav">
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Home</span>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('schedule.index') }}" class="bottom-nav-item {{ request()->routeIs('schedule.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-fill"></i>
                        <span>Jadwal</span>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('messages.index') }}" class="bottom-nav-item position-relative {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-fill"></i>
                        <span>Pesan</span>
                        @if(isset($messageCount) && $messageCount > 0)
                            <span class="badge">{{ $messageCount }}</span>
                        @endif
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('settings.index') }}" class="bottom-nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear-fill"></i>
                        <span>Setting</span>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('profile.index') }}" class="bottom-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person-fill"></i>
                        <span>Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateThemeIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-moon-fill fs-5';
            } else {
                themeIcon.className = 'bi bi-sun-fill fs-5';
            }
        }

        // Close sidebar when clicking menu items
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>