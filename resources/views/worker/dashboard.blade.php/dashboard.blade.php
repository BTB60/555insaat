@extends('layouts.app')

@section('title', 'İşçi Kabineti')
@section('subtitle', 'Şəxsi məlumatlar və statistika')

@section('content')
<!-- Worker Info Card -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="avatar" style="width: 80px; height: 80px; font-size: 32px; margin-right: 20px;">
                {{ substr(auth()->user()?->name ?? 'İ', 0, 1) }}
            </div>
            <div>
                <h2>{{ auth()->user()?->name ?? 'İşçi' }}</h2>
                <p class="text-muted mb-1">{{ auth()->user()?->employee?->position ?? 'Vəzifə təyin edilməyib' }}</p>
                <span class="badge badge-success">Aktiv</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid mb-4">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="bi bi-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3>Bu ay iş günü</h3>
            <p class="stat-value">{{ $workDays ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="bi bi-cash"></i>
        </div>
        <div class="stat-info">
            <h3>Aylıq Maaş</h3>
            <p class="stat-value">{{ number_format($monthlySalary ?? 0, 0) }} ₼</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="bi bi-cash-coin"></i>
        </div>
        <div class="stat-info">
            <h3>Alınan Avans</h3>
            <p class="stat-value">{{ number_format($totalAdvances ?? 0, 0) }} ₼</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <div class="stat-info">
            <h3>Cərimə</h3>
            <p class="stat-value">{{ number_format($totalFines ?? 0, 0) }} ₼</p>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Attendance Summary -->
    <div class="card">
        <div class="card-header">
            <h3><i class="bi bi-calendar-week"></i> Davamiyyət (Bu ay)</h3>
        </div>
        <div class="card-body">
            <div class="attendance-summary">
                <div class="attendance-item">
                    <span class="attendance-label"><i class="bi bi-check-circle text-success"></i> İştirak</span>
                    <span class="attendance-value">{{ $attendanceStats['present'] ?? 0 }}</span>
                </div>
                <div class="attendance-item">
                    <span class="attendance-label"><i class="bi bi-clock text-warning"></i> Gecikmə</span>
                    <span class="attendance-value">{{ $attendanceStats['late'] ?? 0 }}</span>
                </div>
                <div class="attendance-item">
                    <span class="attendance-label"><i class="bi bi-x-circle text-danger"></i> Qayıb</span>
                    <span class="attendance-value">{{ $attendanceStats['absent'] ?? 0 }}</span>
                </div>
                <div class="attendance-item">
                    <span class="attendance-label"><i class="bi bi-umbrella text-info"></i> İznlə</span>
                    <span class="attendance-value">{{ $attendanceStats['excused'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Advances -->
    <div class="card">
        <div class="card-header">
            <h3><i class="bi bi-cash"></i> Son Avanslar</h3>
            <a href="{{ route('worker.advances.index') }}" class="btn btn-sm btn-primary">Bütünü</a>
        </div>
        <div class="card-body">
            @if(count($recentAdvances ?? []) > 0)
                <div class="list-group">
                    @foreach($recentAdvances as $advance)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ number_format($advance->amount, 2) }} ₼</strong>
                            <small class="d-block text-muted">{{ $advance->date?->format('d.m.Y') }}</small>
                        </div>
                        <span class="badge badge-{{ $advance->status === 'approved' ? 'success' : ($advance->status === 'pending' ? 'warning' : 'secondary') }}">
                            {{ $advance->status === 'approved' ? 'Təsdiqləndi' : ($advance->status === 'pending' ? 'Gözləyir' : 'Rədd edildi') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Avans qeydi yoxdur</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Recent Fines -->
<div class="card">
    <div class="card-header">
        <h3><i class="bi bi-exclamation-triangle"></i> Son Cərimələr</h3>
    </div>
    <div class="card-body">
        @if(count($recentFines ?? []) > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tarix</th>
                            <th>Məbləğ</th>
                            <th>Səbəb</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentFines as $fine)
                        <tr>
                            <td>{{ $fine->fine_date?->format('d.m.Y') }}</td>
                            <td class="text-danger">{{ number_format($fine->amount, 2) }} ₼</td>
                            <td>{{ Str::limit($fine->reason, 40) }}</td>
                            <td>
                                <span class="badge badge-{{ $fine->status === 'deducted' ? 'success' : 'warning' }}">
                                    {{ $fine->status === 'deducted' ? 'Çıxıldı' : 'Gözləyir' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-check-circle"></i>
                <p>Cərimə qeydi yoxdur</p>
            </div>
        @endif
    </div>
</div>

<!-- Monthly Salary Detail -->
<div class="card">
    <div class="card-header">
        <h3><i class="bi bi-calculator"></i> Cari Ay Maaş Hesablanması</h3>
    </div>
    <div class="card-body">
        <div class="salary-calculation">
            <div class="salary-row">
                <span>Əsas Maaş:</span>
                <strong>{{ number_format($salaryDetail['base'] ?? 0, 2) }} ₼</strong>
            </div>
            <div class="salary-row text-danger">
                <span>Avans (Çıxılan):</span>
                <strong>-{{ number_format($salaryDetail['advances'] ?? 0, 2) }} ₼</strong>
            </div>
            <div class="salary-row text-danger">
                <span>Cərimə (Çıxılan):</span>
                <strong>-{{ number_format($salaryDetail['fines'] ?? 0, 2) }} ₼</strong>
            </div>
            <div class="salary-row total">
                <span>Yekun Maaş:</span>
                <strong>{{ number_format($salaryDetail['total'] ?? 0, 2) }} ₼</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.attendance-summary {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.attendance-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    background: var(--gray-50);
    border-radius: var(--radius-sm);
}

.attendance-label {
    display: flex;
    align-items: center;
    gap: 8px;
}

.attendance-value {
    font-weight: 600;
    font-size: 18px;
}

.salary-calculation {
    max-width: 400px;
    margin: 0 auto;
}

.salary-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid var(--gray-200);
}

.salary-row.total {
    border-bottom: none;
    border-top: 2px solid var(--primary);
    margin-top: 8px;
    padding-top: 16px;
    font-size: 18px;
}

.salary-row.total strong {
    color: var(--primary);
}

.list-group-item {
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    margin-bottom: 8px;
}
</style>
@endpush