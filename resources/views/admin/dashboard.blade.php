@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="text-muted">{{ now()->format('d.m.Y') }}</span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Ümumi İşçilər</h6>
                        <h2 class="mt-2 mb-0">{{ $stats['total_employees'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Aktiv Obyektlər</h6>
                        <h2 class="mt-2 mb-0">{{ $stats['active_projects'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-building fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Bugün Gələnlər</h6>
                        <h2 class="mt-2 mb-0">{{ $stats['today_present'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-calendar-check fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Gözləyən Avans</h6>
                        <h2 class="mt-2 mb-0">{{ $stats['pending_advances'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-cash-stack fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Attendance Chart -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Aylıq Davamiyyət Statistikası</h5>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Son Əməliyyatlar</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentActivities ?? [] as $activity)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $activity->description }}</p>
                        </div>
                    @empty
                        <div class="list-group-item text-center text-muted py-4">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            Heç bir əməliyyat yoxdur
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <!-- Pending Tasks -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Gözləyən Tapşırıqlar</h5>
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-outline-primary">Hamısı</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tapşırıq</th>
                                <th>Prioritet</th>
                                <th>Son tarix</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingTasks ?? [] as $task)
                                <tr>
                                    <td>{{ Str::limit($task->title, 30) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $task->priority_color }}">
                                            {{ $task->priority_label }}
                                        </span>
                                    </td>
                                    <td>{{ $task->due_date?->format('d.m.Y') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="bi bi-check-circle fs-2 d-block mb-2 text-success"></i>
                                        Gözləyən tapşırıq yoxdur
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Salary Summary -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Cari Ay Maaşları</h5>
                <a href="{{ route('admin.salaries.index') }}" class="btn btn-sm btn-outline-primary">Detallar</a>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-primary">{{ $salaryStats['calculated'] ?? 0 }}</h4>
                        <small class="text-muted">Hesablanmış</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-warning">{{ $salaryStats['pending'] ?? 0 }}</h4>
                        <small class="text-muted">Gözləyən</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-success">{{ $salaryStats['paid'] ?? 0 }}</h4>
                        <small class="text-muted">Ödənilmiş</small>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Ümumi məbləğ:</span>
                    <strong>{{ number_format($salaryStats['total_amount'] ?? 0, 2) }} AZN</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Attendance Chart
const ctx = document.getElementById('attendanceChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Gəlib', 'Gecikib', 'Gəlməyib', 'Üzrlü', 'Məzuniyyət'],
        datasets: [{
            label: 'Bu ay',
            data: [{{ $attendanceData['present'] ?? 0 }}, {{ $attendanceData['late'] ?? 0 }}, {{ $attendanceData['absent'] ?? 0 }}, {{ $attendanceData['excused'] ?? 0 }}, {{ $attendanceData['vacation'] ?? 0 }}],
            backgroundColor: ['#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6c757d'],
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
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endpush
