@extends('layouts.app')

@section('title', 'Hesabatlar')
@section('subtitle', 'Ətraflı statistik hesabatlar')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1>Hesabatlar</h1>
        <p>Statistik və analitik hesabatlar</p>
    </div>
</div>

<!-- Report Types -->
<div class="dashboard-grid mb-4">
    <!-- Attendance Report -->
    <div class="card">
        <div class="card-header">
            <h3><i class="bi bi-calendar-check"></i> Davamiyyət Hesabatı</h3>
        </div>
        <div class="card-body">
            <p>İşçilərin aylıq və illik davamiyyət statistikası</p>
            <form action="{{ route('admin.reports.attendance') }}" method="GET" class="row g-2">
                <div class="col-6">
                    <select class="form-control" name="month">
                        @foreach(['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'İyun', 'İyul', 'Avqust', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr'] as $key => $month)
                            <option value="{{ $key + 1 }}" {{ now()->month == $key + 1 ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <select class="form-control" name="year">
                        @for($y = now()->year; $y >= now()->year - 2; $y--)
                            <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-file-earmark-text"></i> Hesabatı Gör
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Salary Report -->
    <div class="card">
        <div class="card-header">
            <h3><i class="bi bi-cash-stack"></i> Maaş Hesabatı</h3>
        </div>
        <div class="card-body">
            <p>Aylıq maaş hesablanması və ödənişlər</p>
            <form action="{{ route('admin.reports.salary') }}" method="GET" class="row g-2">
                <div class="col-6">
                    <select class="form-control" name="month">
                        @foreach(['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'İyun', 'İyul', 'Avqust', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr'] as $key => $month)
                            <option value="{{ $key + 1 }}" {{ now()->month == $key + 1 ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <select class="form-control" name="year">
                        @for($y = now()->year; $y >= now()->year - 2; $y--)
                            <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-file-earmark-text"></i> Hesabatı Gör
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Project Report -->
    <div class="card">
        <div class="card-header">
            <h3><i class="bi bi-building"></i> Obyekt Hesabatı</h3>
        </div>
        <div class="card-body">
            <p>Obyektlərə görə işçi və xərclər</p>
            <form action="{{ route('admin.reports.project') }}" method="GET" class="row g-2">
                <div class="col-12">
                    <select class="form-control" name="project_id">
                        <option value="">Bütün obyektlər</option>
                        @foreach($projects ?? [] as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-file-earmark-text"></i> Hesabatı Gör
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Employee Report -->
    <div class="card">
        <div class="card-header">
            <h3><i class="bi bi-person"></i> İşçi Hesabatı</h3>
        </div>
        <div class="card-body">
            <p>Tək işçinin detallı hesabatı</p>
            <form action="{{ route('admin.reports.employee') }}" method="GET" class="row g-2">
                <div class="col-12">
                    <select class="form-control" name="employee_id" required>
                        <option value="">İşçi seçin</option>
                        @foreach($employees ?? [] as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-file-earmark-text"></i> Hesabatı Gör
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="card">
    <div class="card-header">
        <h3><i class="bi bi-graph-up"></i> Ümumi Statistika</h3>
    </div>
    <div class="card-body">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-info">
                    <h3>Ümumi İşçi</h3>
                    <p class="stat-value">{{ $totalEmployees ?? 0 }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-info">
                    <h3>Obyektlər</h3>
                    <p class="stat-value">{{ $totalProjects ?? 0 }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-info">
                    <h3>İllik Maaş Fondu</h3>
                    <p class="stat-value">{{ number_format($yearlySalary ?? 0, 0) }} ₼</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3>İllik Cərimə</h3>
                    <p class="stat-value">{{ number_format($yearlyFines ?? 0, 0) }} ₼</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
}
</style>
@endpush