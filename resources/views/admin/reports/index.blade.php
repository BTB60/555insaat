@extends('layouts.app')

@section('title', 'Hesabatlar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Hesabatlar</h1>
</div>

<div class="row g-4">
    <!-- Worker Report -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-people fs-1 text-primary mb-3"></i>
                <h5>İşçi Siyahısı</h5>
                <p class="text-muted">İşçilərin tam siyahısı və məlumatları</p>
                <a href="{{ route('admin.reports.workers') }}" class="btn btn-outline-primary">Hesabatı aç</a>
            </div>
        </div>
    </div>
    
    <!-- Attendance Report -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-calendar-check fs-1 text-success mb-3"></i>
                <h5>Davamiyyət Hesabatı</h5>
                <p class="text-muted">Tarix aralığında davamiyyət məlumatları</p>
                <a href="{{ route('admin.reports.attendance') }}" class="btn btn-outline-success">Hesabatı aç</a>
            </div>
        </div>
    </div>
    
    <!-- Salary Report -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-cash-stack fs-1 text-warning mb-3"></i>
                <h5>Maaş Hesabatı</h5>
                <p class="text-muted">Aylıq maaş hesabatı və ödənişlər</p>
                <a href="{{ route('admin.reports.salary') }}" class="btn btn-outline-warning">Hesabatı aç</a>
            </div>
        </div>
    </div>
    
    <!-- Advance Report -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-cash fs-1 text-info mb-3"></i>
                <h5>Avans Hesabatı</h5>
                <p class="text-muted">Verilən avansların hesabatı</p>
                <a href="{{ route('admin.reports.advances') }}" class="btn btn-outline-info">Hesabatı aç</a>
            </div>
        </div>
    </div>
    
    <!-- Penalty Report -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-triangle fs-1 text-danger mb-3"></i>
                <h5>Cərimə Hesabatı</h5>
                <p class="text-muted">Tətbiq edilən cərimələrin hesabatı</p>
                <a href="{{ route('admin.reports.penalties') }}" class="btn btn-outline-danger">Hesabatı aç</a>
            </div>
        </div>
    </div>
    
    <!-- Task Report -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-list-task fs-1 text-secondary mb-3"></i>
                <h5>Tapşırıq Hesabatı</h5>
                <p class="text-muted">Tapşırıqların icra vəziyyəti</p>
                <a href="{{ route('admin.reports.tasks') }}" class="btn btn-outline-secondary">Hesabatı aç</a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-header">
        <h5 class="mb-0">Export Formatları</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-file-pdf text-danger fs-4 me-2"></i>
                    <span>PDF - Çap üçün optimallaşdırılmış</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-file-excel text-success fs-4 me-2"></i>
                    <span>Excel - Excel proqramında açmaq üçün</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-filetype-csv text-primary fs-4 me-2"></i>
                    <span>CSV - Mətn formatlı data faylı</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
