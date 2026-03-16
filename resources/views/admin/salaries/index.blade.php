@extends('layouts.app')

@section('title', 'Maaşlar')
@section('subtitle', 'İşçi maaşlarının hesablanması və ödənişləri')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1>Maaşlar</h1>
        <p>{{ now()->format('F Y') }} - Cari ay</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.salaries.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-calculator"></i> Maaş Hesabla
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-4">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="bi bi-calculator"></i>
        </div>
        <div class="stat-info">
            <h3>Hesablanan</h3>
            <p class="stat-value">{{ $stats['calculated'] ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div class="stat-info">
            <h3>Gözləyən</h3>
            <p class="stat-value">{{ $stats['pending'] ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Ödənən</h3>
            <p class="stat-value">{{ $stats['paid'] ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="bi bi-cash-stack"></i>
        </div>
        <div class="stat-info">
            <h3>Ümumi Məbləğ</h3>
            <p class="stat-value">{{ number_format($stats['total_amount'] ?? 0, 0) }} ₼</p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.salaries.index') }}" method="GET" class="filter-grid">
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
                <label>İl</label>
                <select class="form-control" name="year">
                    @for($y = now()->year; $y >= now()->year - 2; $y--)
                        <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label>Ay</label>
                <select class="form-control" name="month">
                    @foreach(['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'İyun', 'İyul', 'Avqust', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr'] as $key => $month)
                        <option value="{{ $key + 1 }}" {{ request('month', now()->month) == $key + 1 ? 'selected' : '' }}>{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="">Hamısı</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gözləyir</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Ödənib</option>
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

<!-- Salaries Table -->
<div class="card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>İşçi</th>
                    <th>Dövr</th>
                    <th>Əsas Maaş</th>
                    <th>Avans</th>
                    <th>Cərimə</th>
                    <th>Bonus</th>
                    <th>Yekun</th>
                    <th>Status</th>
                    <th width="150">Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salaries ?? [] as $salary)
                    <tr>
                        <td>
                            <strong>{{ $salary->employee?->full_name ?? '-' }}</strong>
                        </td>
                        <td>{{ $salary->month }}.{{ $salary->year }}</td>
                        <td>{{ number_format($salary->base_salary, 2) }} ₼</td>
                        <td class="text-danger">-{{ number_format($salary->total_advances, 2) }} ₼</td>
                        <td class="text-danger">-{{ number_format($salary->total_fines, 2) }} ₼</td>
                        <td class="text-success">+{{ number_format($salary->bonus, 2) }} ₼</td>
                        <td>
                            <strong>{{ number_format($salary->final_salary, 2) }} ₼</strong>
                        </td>
                        <td>
                            @if($salary->status == 'paid')
                                <span class="badge badge-success">Ödənib</span>
                                <small class="d-block text-muted">{{ $salary->paid_at?->format('d.m.Y') }}</small>
                            @else
                                <span class="badge badge-warning">Gözləyir</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.salaries.show', $salary) }}" class="btn btn-sm btn-info" title="Detallar">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($salary->status == 'pending')
                                    <form action="{{ route('admin.salaries.pay', $salary) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Ödə">
                                            <i class="bi bi-cash"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.salaries.edit', $salary) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="bi bi-cash" style="font-size:48px;color:var(--gray-400);"></i>
                            <p class="mt-3 text-muted">Bu dövr üçün maaş hesablanmayıb</p>
                            <a href="{{ route('admin.salaries.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-calculator"></i> Maaş Hesabla
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(($salaries ?? collect())->hasPages())
    <div class="card-footer">
        {{ $salaries->links() }}
    </div>
    @endif
</div>
@endsection