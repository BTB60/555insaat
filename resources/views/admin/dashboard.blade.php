@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', '555 İnşaat idarəetmə panelinə xoş gəlmisiniz')

@section('content')

<!-- Stats Grid -->
<div class="stats-grid">
    <!-- Ümumi İşçi -->
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="bi bi-people"></i>
        </div>
        <div class="stat-info">
            <h3>Ümumi İşçi</h3>
            <p class="stat-value">{{ $stats['total_employees'] ?? 0 }}</p>
            <small class="stat-detail">Sistemdəki bütün işçilər</small>
        </div>
    </div>
    
    <!-- Aktiv İşçi -->
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="bi bi-person-check"></i>
        </div>
        <div class="stat-info">
            <h3>Aktiv İşçi</h3>
            <p class="stat-value">{{ $stats['active_employees'] ?? 0 }}</p>
            <small class="stat-detail">status = active</small>
        </div>
    </div>
    
    <!-- Bu gün gələn -->
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="bi bi-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3>Bu gün gələn</h3>
            <p class="stat-value">{{ $stats['today_present'] ?? 0 }}</p>
            <small class="stat-detail">Bugünkü davamiyyət</small>
        </div>
    </div>
    
    <!-- Aktiv Obyekt -->
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="bi bi-building"></i>
        </div>
        <div class="stat-info">
            <h3>Aktiv Obyekt</h3>
            <p class="stat-value">{{ $stats['active_projects'] ?? 0 }}</p>
            <small class="stat-detail">Aktiv layihələr</small>
        </div>
    </div>
    
    <!-- Aylıq Maaş Fondu -->
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="bi bi-cash-stack"></i>
        </div>
        <div class="stat-info">
            <h3>Aylıq Maaş Fondu</h3>
            <p class="stat-value">{{ number_format($salaryStats['total_amount'] ?? 0, 0) }} ₼</p>
            <small class="stat-detail">Bütün işçilərin cəmi</small>
        </div>
    </div>
    
    <!-- Bu ay cərimə -->
    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <div class="stat-info">
            <h3>Bu ay cərimə</h3>
            <p class="stat-value">{{ number_format($stats['monthly_fines'] ?? 0, 0) }} ₼</p>
            <small class="stat-detail">Cari ay cərimələr</small>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Attendance Chart -->
    <div class="card chart-card">
        <div class="card-header">
            <h2><i class="bi bi-pie-chart"></i> Aylıq Davamiyyət</h2>
        </div>
        <div class="card-body">
            <canvas id="attendanceChart" height="200"></canvas>
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-dot present"></span>
                    <span>İştirak: {{ $attendanceData['present'] ?? 0 }}</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot late"></span>
                    <span>Gecikmə: {{ $attendanceData['late'] ?? 0 }}</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot absent"></span>
                    <span>Qayıb: {{ $attendanceData['absent'] ?? 0 }}</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot excused"></span>
                    <span>İznlə: {{ $attendanceData['excused'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Salary Stats -->
    <div class="card">
        <div class="card-header">
            <h2><i class="bi bi-cash"></i> Maaş Statusu</h2>
            <span class="badge badge-primary">{{ now()->format('F Y') }}</span>
        </div>
        <div class="card-body">
            <div class="progress-list">
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Hesablanan</span>
                        <span>{{ $salaryStats['calculated'] ?? 0 }}</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill blue" style="width: {{ $salaryStats['calculated'] > 0 ? 100 : 0 }}%"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Gözləyən</span>
                        <span>{{ $salaryStats['pending'] ?? 0 }}</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill orange" style="width: {{ ($salaryStats['pending'] / max($salaryStats['calculated'], 1)) * 100 }}%"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Ödənən</span>
                        <span>{{ $salaryStats['paid'] ?? 0 }}</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill green" style="width: {{ ($salaryStats['paid'] / max($salaryStats['calculated'], 1)) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Pending Tasks -->
    <div class="card">
        <div class="card-header">
            <h2><i class="bi bi-list-task"></i> Gözləyən Tapşırıqlar</h2>
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-primary">Bütünü</a>
        </div>
        <div class="card-body">
            @if(count($pendingTasks ?? []) > 0)
                <div class="task-list">
                    @foreach($pendingTasks as $task)
                    <div class="task-item">
                        <div class="task-info">
                            <h4>{{ $task->title }}</h4>
                            <p>{{ Str::limit($task->description, 50) }}</p>
                            <small class="task-date">
                                <i class="bi bi-calendar"></i> 
                                Son tarix: {{ $task->due_date?->format('d.m.Y') }}
                            </small>
                        </div>
                        <span class="badge badge-{{ $task->status === 'pending' ? 'warning' : 'info' }}">
                            {{ $task->status === 'pending' ? 'Gözləyir' : 'Davam edir' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-check-circle"></i>
                    <p>Gözləyən tapşırıq yoxdur</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Pending Advances -->
    <div class="card">
        <div class="card-header">
            <h2><i class="bi bi-cash"></i> Gözləyən Avanslar</h2>
            <a href="{{ route('admin.advances.index') }}" class="btn btn-sm btn-primary">Bütünü</a>
        </div>
        <div class="card-body">
            @if(($stats['pending_advances'] ?? 0) > 0)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>{{ $stats['pending_advances'] }}</strong> təsdiq gözləyən avans var
                </div>
                <a href="{{ route('admin.advances.index', ['status' => 'pending']) }}" class="btn btn-warning">
                    <i class="bi bi-eye"></i> Bax
                </a>
            @else
                <div class="empty-state">
                    <i class="bi bi-check-circle"></i>
                    <p>Gözləyən avans yoxdur</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="card">
    <div class="card-header">
        <h2><i class="bi bi-clock-history"></i> Son Aktivliklər</h2>
    </div>
    <div class="card-body">
        @if(count($recentActivities ?? []) > 0)
            <div class="activity-list">
                @foreach($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon {{ $activity->action }}">
                        <i class="bi bi-{{ $activity->action === 'create' ? 'plus' : ($activity->action === 'update' ? 'pencil' : 'trash') }}"></i>
                    </div>
                    <div class="activity-content">
                        <p>{{ $activity->description }}</p>
                        <small>{{ $activity->created_at?->diffForHumans() }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>Aktivlik yoxdur</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 24px;
    margin-bottom: 24px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: var(--gray-800);
    margin: 8px 0;
}

.stat-detail {
    color: var(--gray-500);
}

.chart-card {
    min-height: 350px;
}

.chart-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--gray-200);
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.legend-dot.present { background: var(--success); }
.legend-dot.late { background: var(--warning); }
.legend-dot.absent { background: var(--danger); }
.legend-dot.excused { background: var(--info); }

.progress-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.progress-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: var(--gray-600);
}

.progress-bar {
    height: 8px;
    background: var(--gray-200);
    border-radius: var(--radius-full);
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: var(--radius-full);
    transition: width 0.3s ease;
}

.progress-fill.blue { background: var(--info); }
.progress-fill.orange { background: var(--warning); }
.progress-fill.green { background: var(--success); }

.task-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.task-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 12px;
    background: var(--gray-50);
    border-radius: var(--radius-sm);
}

.task-info h4 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.task-info p {
    font-size: 13px;
    color: var(--gray-500);
    margin-bottom: 4px;
}

.task-date {
    color: var(--gray-400);
    font-size: 12px;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-bottom: 1px solid var(--gray-100);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

.activity-icon.create { background: var(--success); }
.activity-icon.update { background: var(--info); }
.activity-icon.delete { background: var(--danger); }

.activity-content p {
    font-size: 14px;
    margin-bottom: 2px;
}

.activity-content small {
    color: var(--gray-400);
    font-size: 12px;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--gray-400);
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 12px;
    display: block;
}

@media (max-width: 768px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .chart-legend {
        flex-direction: column;
        gap: 8px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Attendance Chart
    const ctx = document.getElementById('attendanceChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['İştirak', 'Gecikmə', 'Qayıb', 'İznlə', 'Məzuniyyət'],
                datasets: [{
                    data: [
                        {{ $attendanceData['present'] ?? 0 }},
                        {{ $attendanceData['late'] ?? 0 }},
                        {{ $attendanceData['absent'] ?? 0 }},
                        {{ $attendanceData['excused'] ?? 0 }},
                        {{ $attendanceData['vacation'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                        '#3b82f6',
                        '#8b5cf6'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });
    }
</script>
@endpush
