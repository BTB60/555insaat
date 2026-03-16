@extends('layouts.app')

@section('title', 'Tapşırıqlar')
@section('subtitle', 'İş tapşırıqlarının idarəetməsi')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1>Tapşırıqlar</h1>
        <p>Gözləyən: {{ ($tasks ?? collect())->where('status', 'pending')->count() }} ədəd</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-lg"></i> Yeni Tapşırıq
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-4">
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div class="stat-info">
            <h3>Gözləyən</h3>
            <p class="stat-value">{{ ($tasks ?? collect())->where('status', 'pending')->count() }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="bi bi-arrow-repeat"></i>
        </div>
        <div class="stat-info">
            <h3>Davam edir</h3>
            <p class="stat-value">{{ ($tasks ?? collect())->where('status', 'in_progress')->count() }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Tamamlanan</h3>
            <p class="stat-value">{{ ($tasks ?? collect())->where('status', 'completed')->count() }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="stat-info">
            <h3>Gecikən</h3>
            <p class="stat-value">{{ ($tasks ?? collect())->where('due_date', '<', now())->where('status', '!=', 'completed')->count() }}</p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.tasks.index') }}" method="GET" class="filter-grid">
            <div class="form-group">
                <label>Axtarış</label>
                <input type="text" class="form-control" name="search" placeholder="Başlıq..." value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <label>Təyin edilən</label>
                <select class="form-control" name="assigned_to">
                    <option value="">Hamısı</option>
                    @foreach($employees ?? [] as $employee)
                        <option value="{{ $employee->id }}" {{ request('assigned_to') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->full_name }}
                        </option>
                    @endforeach
                </select>
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
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gözləyir</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Davam edir</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Ləğv edildi</option>
                </select>
            </div>
            <div class="form-group">
                <label>Prioritet</label>
                <select class="form-control" name="priority">
                    <option value="">Hamısı</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Aşağı</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Orta</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Yüksək</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Təcili</option>
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

<!-- Tasks Table -->
<div class="card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tapşırıq</th>
                    <th>Təyin edilən</th>
                    <th>Obyekt</th>
                    <th>Son tarix</th>
                    <th>Prioritet</th>
                    <th>Status</th>
                    <th width="150">Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks ?? [] as $task)
                    <tr class="{{ $task->due_date < now() && $task->status != 'completed' ? 'table-danger' : '' }}">
                        <td>
                            <strong>{{ $task->title }}</strong>
                            <small class="d-block text-muted">{{ Str::limit($task->description, 40) }}</small>
                        </td>
                        <td>{{ $task->assignedTo?->full_name ?? '-' }}</td>
                        <td>{{ $task->project?->name ?? '-' }}</td>
                        <td>
                            {{ $task->due_date?->format('d.m.Y') }}
                            @if($task->due_date < now() && $task->status != 'completed')
                                <span class="badge badge-danger">Gecikdi</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $priorityColors = ['low' => 'secondary', 'medium' => 'info', 'high' => 'warning', 'urgent' => 'danger'];
                                $priorityLabels = ['low' => 'Aşağı', 'medium' => 'Orta', 'high' => 'Yüksək', 'urgent' => 'Təcili'];
                            @endphp
                            <span class="badge badge-{{ $priorityColors[$task->priority] ?? 'secondary' }}">
                                {{ $priorityLabels[$task->priority] ?? $task->priority }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusColors = ['pending' => 'warning', 'in_progress' => 'info', 'completed' => 'success', 'cancelled' => 'secondary'];
                                $statusLabels = ['pending' => 'Gözləyir', 'in_progress' => 'Davam edir', 'completed' => 'Tamamlandı', 'cancelled' => 'Ləğv edildi'];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$task->status] ?? 'secondary' }}">
                                {{ $statusLabels[$task->status] ?? $task->status }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-sm btn-info" title="Bax">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($task->status != 'completed')
                                    <form action="{{ route('admin.tasks.complete', $task) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Tamamla">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-list-task" style="font-size:48px;color:var(--gray-400);"></i>
                            <p class="mt-3 text-muted">Tapşırıq yoxdur</p>
                            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-lg"></i> Yeni Tapşırıq Əlavə Et
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(($tasks ?? collect())->hasPages())
    <div class="card-footer">
        {{ $tasks->links() }}
    </div>
    @endif
</div>
@endsection