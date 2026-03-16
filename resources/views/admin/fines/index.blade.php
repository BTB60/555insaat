@extends('layouts.app')

@section('title', 'Cərimələr')
@section('subtitle', 'İşçi cərimələrinin idarəetməsi')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1>Cərimələr</h1>
        <p>Cari ay: {{ number_format($monthlyTotal ?? 0, 0) }} ₼</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.fines.create') }}" class="btn btn-danger btn-lg">
            <i class="bi bi-plus-lg"></i> Yeni Cərimə
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid three mb-4">
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <div class="stat-info">
            <h3>Aktiv Cərimələr</h3>
            <p class="stat-value">{{ ($fines ?? collect())->where('status', 'active')->count() }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Çıxılan</h3>
            <p class="stat-value">{{ ($fines ?? collect())->where('status', 'deducted')->count() }}</p>
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
        <form action="{{ route('admin.fines.index') }}" method="GET" class="filter-grid">
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
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktiv</option>
                    <option value="deducted" {{ request('status') == 'deducted' ? 'selected' : '' }}>Çıxıldı</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Ləğv edildi</option>
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

<!-- Fines Table -->
<div class="card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>İşçi</th>
                    <th>Məbləğ</th>
                    <th>Səbəb</th>
                    <th>Tarix</th>
                    <th>Obyekt</th>
                    <th>Status</th>
                    <th width="150">Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fines ?? [] as $fine)
                    <tr>
                        <td>
                            <strong>{{ $fine->employee?->full_name ?? '-' }}</strong>
                        </td>
                        <td>
                            <strong class="text-danger">{{ number_format($fine->amount, 2) }} ₼</strong>
                        </td>
                        <td>{{ Str::limit($fine->reason, 30) ?? '-' }}</td>
                        <td>{{ $fine->fine_date?->format('d.m.Y') }}</td>
                        <td>{{ $fine->project?->name ?? '-' }}</td>
                        <td>
                            @php
                                $statusColors = ['active' => 'warning', 'deducted' => 'success', 'cancelled' => 'secondary'];
                                $statusLabels = ['active' => 'Aktiv', 'deducted' => 'Çıxıldı', 'cancelled' => 'Ləğv edildi'];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$fine->status] ?? 'secondary' }}">
                                {{ $statusLabels[$fine->status] ?? $fine->status }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                @if($fine->status == 'active')
                                    <form action="{{ route('admin.fines.deduct', $fine) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Maaşdan çıx">
                                            <i class="bi bi-cash"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.fines.edit', $fine) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.fines.destroy', $fine) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                            <i class="bi bi-exclamation-triangle" style="font-size:48px;color:var(--gray-400);"></i>
                            <p class="mt-3 text-muted">Cərimə qeydi yoxdur</p>
                            <a href="{{ route('admin.fines.create') }}" class="btn btn-danger mt-2">
                                <i class="bi bi-plus-lg"></i> Yeni Cərimə Əlavə Et
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(($fines ?? collect())->hasPages())
    <div class="card-footer">
        {{ $fines->links() }}
    </div>
    @endif
</div>
@endsection