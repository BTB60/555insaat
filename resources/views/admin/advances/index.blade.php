@extends('layouts.app')

@section('title', 'Avanslar')
@section('subtitle', 'İşçi avanslarının idarəetməsi')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1>Avanslar</h1>
        <p>Gözləyən: {{ ($advances ?? collect())->where('status', 'pending')->count() }} ədəd</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.advances.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-lg"></i> Yeni Avans
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid three mb-4">
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div class="stat-info">
            <h3>Gözləyən</h3>
            <p class="stat-value">{{ ($advances ?? collect())->where('status', 'pending')->count() }}</p>
            <small>{{ number_format(($advances ?? collect())->where('status', 'pending')->sum('amount'), 0) }} ₼</small>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Təsdiqlənən</h3>
            <p class="stat-value">{{ ($advances ?? collect())->where('status', 'approved')->count() }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="bi bi-cash-stack"></i>
        </div>
        <div class="stat-info">
            <h3>Ümumi (Ay)</h3>
            <p class="stat-value">{{ number_format($monthlyTotal ?? 0, 0) }} ₼</p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.advances.index') }}" method="GET" class="filter-grid">
            <div class="form-group">
                <label>İşçi</label>
                <select class="form-control" name="employee_id">
                    <option value="">Hamısı</option>
                    @foreach($employees ?? [] as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="">Hamısı</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gözləyir</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Təsdiqləndi</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rədd edildi</option>
                    <option value="deducted" {{ request('status') == 'deducted' ? 'selected' : '' }}>Çıxıldı</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tarixdən</label>
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="form-group">
                <label>Tarixədək</label>
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
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

<!-- Advances Table -->
<div class="card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>İşçi</th>
                    <th>Məbləğ</th>
                    <th>Səbəb</th>
                    <th>Tarix</th>
                    <th>Status</th>
                    <th>Qeyd</th>
                    <th width="150">Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($advances ?? [] as $advance)
                    <tr>
                        <td>
                            <strong>{{ $advance->employee?->full_name ?? '-' }}</strong>
                        </td>
                        <td>
                            <strong>{{ number_format($advance->amount, 2) }} ₼</strong>
                        </td>
                        <td>{{ Str::limit($advance->reason, 30) ?? '-' }}</td>
                        <td>{{ $advance->date?->format('d.m.Y') }}</td>
                        <td>
                            @php
                                $statusColors = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'deducted' => 'info'];
                                $statusLabels = ['pending' => 'Gözləyir', 'approved' => 'Təsdiqləndi', 'rejected' => 'Rədd edildi', 'deducted' => 'Çıxıldı'];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$advance->status] ?? 'secondary' }}">
                                {{ $statusLabels[$advance->status] ?? $advance->status }}
                            </span>
                        </td>
                        <td>{{ Str::limit($advance->note, 20) ?? '-' }}</td>
                        <td>
                            <div class="btn-group">
                                @if($advance->status == 'pending')
                                    <form action="{{ route('admin.advances.approve', $advance) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Təsdiqlə">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.advances.reject', $advance) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="Rədd et">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.advances.edit', $advance) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.advances.destroy', $advance) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                            <i class="bi bi-cash" style="font-size:48px;color:var(--gray-400);"></i>
                            <p class="mt-3 text-muted">Avans qeydi yoxdur</p>
                            <a href="{{ route('admin.advances.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-lg"></i> Yeni Avans Əlavə Et
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(($advances ?? collect())->hasPages())
    <div class="card-footer">
        {{ $advances->links() }}
    </div>
    @endif
</div>
@endsection