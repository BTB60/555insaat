@extends('layouts.app')

@section('title', 'Davamiyyət')
@section('subtitle', 'İşçilərin gəliş-gediş qeydiyyatı')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1>Davamiyyət</h1>
        <p>{{ now()->format('d.m.Y') }} - Bugünkü davamiyyət</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.attendances.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-lg"></i> Yeni Qeyd
        </a>
        <a href="{{ route('admin.attendances.daily') }}" class="btn btn-secondary">
            <i class="bi bi-calendar"></i> Günlük Baxış
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-4">
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>İştirak edən</h3>
            <p class="stat-value">{{ $todayStats['present'] ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="bi bi-clock"></i>
        </div>
        <div class="stat-info">
            <h3>Gecikən</h3>
            <p class="stat-value">{{ $todayStats['late'] ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="bi bi-x-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Qayıb</h3>
            <p class="stat-value">{{ $todayStats['absent'] ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon info">
            <i class="bi bi-umbrella"></i>
        </div>
        <div class="stat-info">
            <h3>İznlə</h3>
            <p class="stat-value">{{ $todayStats['excused'] ?? 0 }}</p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.attendances.index') }}" method="GET" class="filter-grid">
            <div class="form-group">
                <label>Tarix</label>
                <input type="date" class="form-control" name="date" value="{{ request('date', now()->format('Y-m-d')) }}">
            </div>
            <div class="form-group">
                <label>Obyekt</label>
                <select class="form-control" name="project_id">
                    <option value="">Hamısı</option>
                    @foreach($projects ?? [] as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="">Hamısı</option>
                    <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>İştirak</option>
                    <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Gecikmə</option>
                    <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Qayıb</option>
                    <option value="excused" {{ request('status') == 'excused' ? 'selected' : '' }}>İznlə</option>
                </select>
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search"></i> Filtr
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Actions -->
<div class="card mb-4">
    <div class="card-header">
        <h3><i class="bi bi-lightning"></i> Sürətli Əməliyyatlar</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.attendance.bulk') }}" method="POST">
            @csrf
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label>Obyekt</label>
                    <select class="form-control" name="project_id" required>
                        <option value="">Seçin</option>
                        @foreach($projects ?? [] as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Tarix</label>
                    <input type="date" class="form-control" name="date" value="{{ now()->format('Y-m-d') }}" required>
                </div>
                <div class="col-md-3">
                    <label>Status</label>
                    <select class="form-control" name="status" required>
                        <option value="present">Hamısı iştirak edib</option>
                        <option value="absent">Hamısı qayıb</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-all"></i> Tətbiq Et
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Attendance Table -->
<div class="card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>İşçi</th>
                    <th>Obyekt</th>
                    <th>Tarix</th>
                    <th>Giriş</th>
                    <th>Çıxış</th>
                    <th>Status</th>
                    <th>Qeyd</th>
                    <th width="120">Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances ?? [] as $attendance)
                    <tr>
                        <td>
                            <strong>{{ $attendance->employee?->full_name ?? '-' }}</strong>
                        </td>
                        <td>{{ $attendance->project?->name ?? '-' }}</td>
                        <td>{{ $attendance->date?->format('d.m.Y') }}</td>
                        <td>{{ $attendance->check_in ?? '-' }}</td>
                        <td>{{ $attendance->check_out ?? '-' }}</td>
                        <td>
                            @php
                                $statusColors = ['present' => 'success', 'late' => 'warning', 'absent' => 'danger', 'excused' => 'info', 'vacation' => 'secondary'];
                                $statusLabels = ['present' => 'İştirak', 'late' => 'Gecikmə', 'absent' => 'Qayıb', 'excused' => 'İznlə', 'vacation' => 'Məzuniyyət'];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$attendance->status] ?? 'secondary' }}">
                                {{ $statusLabels[$attendance->status] ?? $attendance->status }}
                            </span>
                        </td>
                        <td>{{ Str::limit($attendance->note, 20) ?? '-' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.attendances.edit', $attendance) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.attendances.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-calendar-x" style="font-size:48px;color:var(--gray-400);"></i>
                            <p class="mt-3 text-muted">Bu tarixdə qeyd yoxdur</p>
                            <a href="{{ route('admin.attendances.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-lg"></i> Yeni Qeyd Əlavə Et
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(($attendances ?? collect())->hasPages())
    <div class="card-footer">
        {{ $attendances->links() }}
    </div>
    @endif
</div>
@endsection