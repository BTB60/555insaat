@extends('layouts.app')

@section('title', 'Avanslar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Avanslar</h1>
    <a href="{{ route('admin.advances.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Yeni Avans
    </a>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.advances.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
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
                <select class="form-select" name="status">
                    <option value="">Bütün statuslar</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Gözləmədə</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Təsdiqlənib</option>
                    <option value="deducted" {{ request('status') == 'deducted' ? 'selected' : '' }}>Çıxılıb</option>
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
        <div class="card bg-warning text-dark">
            <div class="card-body text-center">
                <h4>{{ number_format($advances->where('status', 'pending')->sum('amount'), 2) }} AZN</h4>
                <small>Gözləyən</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4>{{ number_format($advances->where('status', 'approved')->sum('amount'), 2) }} AZN</h4>
                <small>Təsdiqlənib</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4>{{ number_format($advances->where('status', 'deducted')->sum('amount'), 2) }} AZN</h4>
                <small>Çıxılıb</small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="advancesTable">
                <thead>
                    <tr>
                        <th>İşçi</th>
                        <th>Məbləğ</th>
                        <th>Tarix</th>
                        <th>Səbəb</th>
                        <th>Status</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advances as $advance)
                        <tr>
                            <td>{{ $advance->employee->full_name }}</td>
                            <td><strong>{{ number_format($advance->amount, 2) }} AZN</strong></td>
                            <td>{{ $advance->date->format('d.m.Y') }}</td>
                            <td>{{ $advance->reason ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $advance->status_color }}">
                                    {{ $advance->status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($advance->status === 'pending')
                                        <form action="{{ route('admin.advances.approve', $advance) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success" title="Təsdiqlə">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.advances.edit', $advance) }}" class="btn btn-warning" title="Redaktə">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.advances.destroy', $advance) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                Heç bir avans tapılmadı
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $advances->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#advancesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 25,
        ordering: true
    });
});
</script>
@endpush
