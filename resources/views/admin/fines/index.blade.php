@extends('layouts.app')

@section('title', 'Cərimələr')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Cərimələr</h1>
    <a href="{{ route('admin.fines.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-lg"></i> Yeni Cərimə
    </a>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.fines.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select class="form-select" name="employee_id">
                    <option value="">Bütün işçilər</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="project_id">
                    <option value="">Bütün obyektlər</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">Bütün statuslar</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktiv</option>
                    <option value="deducted" {{ request('status') == 'deducted' ? 'selected' : '' }}>Çıxılıb</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Ləğv edilib</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Filtrə
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h4>{{ number_format($fines->where('status', 'active')->sum('amount'), 2) }} AZN</h4>
                <small>Aktiv</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4>{{ number_format($fines->where('status', 'deducted')->sum('amount'), 2) }} AZN</h4>
                <small>Çıxılıb</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h4>{{ number_format($fines->where('status', 'cancelled')->sum('amount'), 2) }} AZN</h4>
                <small>Ləğv edilib</small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="finesTable">
                <thead>
                    <tr>
                        <th>İşçi</th>
                        <th>Obyekt</th>
                        <th>Məbləğ</th>
                        <th>Səbəb</th>
                        <th>Tarix</th>
                        <th>Status</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fines as $fine)
                        <tr>
                            <td>{{ $fine->employee->full_name }}</td>
                            <td>{{ $fine->project?->name ?? '-' }}</td>
                            <td><strong class="text-danger">{{ number_format($fine->amount, 2) }} AZN</strong></td>
                            <td>{{ $fine->reason }}</td>
                            <td>{{ $fine->fine_date->format('d.m.Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $fine->status_color }}">
                                    {{ $fine->status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($fine->status === 'active')
                                        <form action="{{ route('admin.fines.cancel', $fine) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary" title="Ləğv et">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.fines.edit', $fine) }}" class="btn btn-warning" title="Redaktə">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.fines.destroy', $fine) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                Heç bir cərimə tapılmadı
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $fines->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#finesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 25,
        ordering: true
    });
});
</script>
@endpush
