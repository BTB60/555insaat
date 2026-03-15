@extends('layouts.app')

@section('title', 'Şəxsi Kabinet')

@section('content')
<div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar employee-sidebar">
        <div class="sidebar-header">
            <i class="bi bi-building"></i>
            <div>
                <h3>555 İnşaat</h3>
                <small>Şəxsi Kabinet</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('worker.dashboard') }}" class="nav-item active">
                <i class="bi bi-person"></i> Profil
            </a>
            <a href="{{ route('worker.attendances') }}" class="nav-item">
                <i class="bi bi-calendar-check"></i> Davamiyyət
            </a>
            <a href="{{ route('worker.salaries') }}" class="nav-item">
                <i class="bi bi-cash-stack"></i> Maaş
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div>
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>İşçi</small>
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
                <h1>Profil Məlumatları</h1>
                <p>Şəxsi kabinetinizə xoş gəlmisiniz</p>
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

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <span>{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <div class="profile-info">
                <h2>{{ auth()->user()->name }}</h2>
                <p>{{ $employee->position ?? 'İşçi' }}</p>
                <span class="status-badge active">Aktiv</span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid three">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>Bu Ay İş Günü</h3>
                    <p>{{ $employee->work_days ?? 22 }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-info">
                    <h3>Aylıq Maaş</h3>
                    <p>{{ number_format($employee->base_salary ?? 0, 2) }} ₼</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-cash"></i>
                </div>
                <div class="stat-info">
                    <h3>Cari Avans</h3>
                    <p>{{ number_format($current_advance ?? 0, 2) }} ₼</p>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <div class="panel">
                <div class="panel-header">
                    <h3><i class="bi bi-person-vcard"></i> Şəxsi Məlumatlar</h3>
                </div>
                <div class="info-list">
                    <div class="info-item">
                        <span class="label">Ad Soyad:</span>
                        <span class="value">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Email:</span>
                        <span class="value">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Telefon:</span>
                        <span class="value">{{ auth()->user()->phone ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Vəzifə:</span>
                        <span class="value">{{ $employee->position ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Şöbə:</span>
                        <span class="value">{{ $employee->department ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h3><i class="bi bi-building"></i> Təyinat Məlumatları</h3>
                </div>
                <div class="info-list">
                    <div class="info-item">
                        <span class="label">Obyekt:</span>
                        <span class="value">{{ $employee->currentProject->name ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Status:</span>
                        <span class="value"><span class="badge active">Aktiv</span></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Qeydiyyat tarixi:</span>
                        <span class="value">{{ $employee->created_at ? $employee->created_at->format('d.m.Y') : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
