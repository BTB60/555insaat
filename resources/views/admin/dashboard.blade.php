@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <i class="bi bi-building"></i>
            <div>
                <h3>555 İnşaat</h3>
                <small>Admin Panel</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.employees.index') }}" class="nav-item">
                <i class="bi bi-people"></i> İşçilər
            </a>
            <a href="{{ route('admin.projects.index') }}" class="nav-item">
                <i class="bi bi-building"></i> Obyektlər
            </a>
            <a href="{{ route('admin.attendances.index') }}" class="nav-item">
                <i class="bi bi-calendar-check"></i> Davamiyyət
            </a>
            <a href="{{ route('admin.salaries.index') }}" class="nav-item">
                <i class="bi bi-cash-stack"></i> Maaşlar
            </a>
            <a href="{{ route('admin.advances.index') }}" class="nav-item">
                <i class="bi bi-cash"></i> Avanslar
            </a>
            <a href="{{ route('admin.fines.index') }}" class="nav-item">
                <i class="bi bi-exclamation-triangle"></i> Cərimələr
            </a>
            <a href="{{ route('admin.tasks.index') }}" class="nav-item">
                <i class="bi bi-list-task"></i> Tapşırıqlar
            </a>
            <a href="{{ route('admin.reports.index') }}" class="nav-item">
                <i class="bi bi-graph-up"></i> Hesabatlar
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div>
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>Admin</small>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Çıxış
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <h1>Dashboard</h1>
                <p>555 İnşaat idarəetmə panelinə xoş gəlmisiniz</p>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Axtarış...">
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-info">
                    <h3>Ümumi İşçi</h3>
                    <p>{{ $stats['total_employees'] ?? 0 }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stat-info">
                    <h3>Aktiv İşçi</h3>
                    <p>{{ $stats['active_employees'] ?? 0 }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>Bu Gün Gələn</h3>
                    <p>{{ $stats['today_attendance'] ?? 0 }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-info">
                    <h3>Aktiv Obyekt</h3>
                    <p>{{ $stats['active_projects'] ?? 0 }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon teal">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-info">
                    <h3>Aylıq Maaş Fondu</h3>
                    <p>{{ number_format($stats['monthly_salary_fund'] ?? 0, 2) }} ₼</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3>Bu Ay Cərimə</h3>
                    <p>{{ number_format($stats['monthly_fines'] ?? 0, 2) }} ₼</p>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <div class="panel large">
                <div class="panel-header">
                    <h2><i class="bi bi-people"></i> Son əlavə olunan işçilər</h2>
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-primary">Hamısına bax</a>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Ad Soyad</th>
                                <th>Telefon</th>
                                <th>Vəzifə</th>
                                <th>Obyekt</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_employees ?? [] as $employee)
                                <tr>
                                    <td>{{ $employee->user->name ?? '-' }}</td>
                                    <td>{{ $employee->user->phone ?? '-' }}</td>
                                    <td>{{ $employee->position ?? '-' }}</td>
                                    <td>{{ $employee->currentProject->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $employee->status == 'active' ? 'active' : 'inactive' }}">
                                            {{ $employee->status == 'active' ? 'Aktiv' : 'Passiv' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">İşçi yoxdur</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="side-panels">
                <div class="panel">
                    <div class="panel-header">
                        <h2><i class="bi bi-list-task"></i> Son Tapşırıqlar</h2>
                    </div>
                    <ul class="list-group">
                        @forelse($recent_tasks ?? [] as $task)
                            <li>{{ $task->title }}</li>
                        @empty
                            <li class="text-muted">Tapşırıq yoxdur</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
