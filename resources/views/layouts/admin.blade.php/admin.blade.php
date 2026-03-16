<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - 555 İnşaat</title>
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <i class="bi bi-building"></i>
                <div>
                    <h3>555 İnşaat</h3>
                    <small>Admin Panel</small>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.employees.index') }}" class="nav-item {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>İşçilər</span>
                </a>
                <a href="{{ route('admin.projects.index') }}" class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Obyektlər</span>
                </a>
                <a href="{{ route('admin.attendances.index') }}" class="nav-item {{ request()->routeIs('admin.attendances.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Davamiyyət</span>
                </a>
                <a href="{{ route('admin.salaries.index') }}" class="nav-item {{ request()->routeIs('admin.salaries.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    <span>Maaşlar</span>
                </a>
                <a href="{{ route('admin.advances.index') }}" class="nav-item {{ request()->routeIs('admin.advances.*') ? 'active' : '' }}">
                    <i class="bi bi-cash"></i>
                    <span>Avanslar</span>
                </a>
                <a href="{{ route('admin.fines.index') }}" class="nav-item {{ request()->routeIs('admin.fines.*') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Cərimələr</span>
                </a>
                <a href="{{ route('admin.tasks.index') }}" class="nav-item {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                    <i class="bi bi-list-task"></i>
                    <span>Tapşırıqlar</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up"></i>
                    <span>Hesabatlar</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="avatar">A</div>
                    <div>
                        <strong>Admin</strong>
                        <small>Administrator</small>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Mobile Header -->
            <header class="mobile-header">
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="bi bi-list"></i>
                </button>
                <h1>@yield('title', 'Dashboard')</h1>
                <div class="mobile-user">
                    <div class="avatar">A</div>
                </div>
            </header>

            <!-- Topbar -->
            <header class="topbar">
                <div class="topbar-left">
                    <h1>@yield('title', 'Dashboard')</h1>
                    <p>@yield('subtitle', '555 İnşaat idarəetmə paneli')</p>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Axtarış...">
                    </div>
                    <button class="btn-icon" id="themeToggle">
                        <i class="bi bi-moon"></i>
                    </button>
                </div>
            </header>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i>
                    <span>{{ session('success') }}</span>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>{{ session('error') }}</span>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- App JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        });

        // Overlay click
        document.getElementById('sidebarOverlay')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            this.classList.remove('active');
        });

        // Theme toggle
        document.getElementById('themeToggle')?.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const icon = this.querySelector('i');
            if (document.body.classList.contains('dark-mode')) {
                icon.classList.replace('bi-moon', 'bi-sun');
            } else {
                icon.classList.replace('bi-sun', 'bi-moon');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
