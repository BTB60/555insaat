@extends('layouts.app')

@section('title', 'Davamiyyət')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Davamiyyət</h1>
    <div>
        <a href="{{ route('admin.attendances.create') }}" class="btn btn-success me-2">
            <i class="bi bi-plus-lg"></i> Toplu Qeyd
        </a>
        <a href="{{ route('admin.attendances.report') }}" class="btn btn-outline-primary">
            <i class="bi bi-graph-up"></i> Hesabat
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.attendances.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tarix</label>
                <input type="date" class="form-control" name="date" value="{{ request('date', today()->format('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Obyekt</label>
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
                <label class="form-label">İşçi</label>
                <select class="form-select" name="employee_id">
                    <option value="">Bütün işçilər</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-2"></i>Filtrə
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="card bg-success text-white text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $attendances->where('status', 'present')->count() }}</h4>
                <small>Gəlib</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-dark text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $attendances->where('status', 'late')->count() }}</h4>
                <small>Gecikib</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $attendances->where('status', 'absent')->count() }}</h4>
                <small>Gəlməyib</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $attendances->where('status', 'excused')->count() }}</h4>
                <small>Üzrlü</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-primary text-white text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $attendances->where('status', 'vacation')->count() }}</h4>
                <small>Məzuniyyət</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-secondary text-white text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $attendances->where('status', 'sick')->count() }}</h4>
                <small>Xəstə</small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="attendancesTable">
                <thead>
                    <tr>
                        <th>Tarix</th>
                        <th>İşçi</th>
                        <th>Obyekt</th>
                        <th>Status</th>
                        <th>Giriş</th>
                        <th>Çıxış</th>
                        <th>Qeyd</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->date->format('d.m.Y') }}</td>
                            <td>{{ $attendance->employee->full_name }}</td>
                            <td>{{ $attendance->project?->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $attendance->status_color }}">
                                    {{ $attendance->status_label }}
                                </span>
                            </td>
                            <td>{{ $attendance->check_in ?? '-' }}</td>
                            <td>{{ $attendance->check_out ?? '-' }}</td>
                            <td>{{ $attendance->note ?? '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.attendances.edit', $attendance) }}" class="btn btn-warning" title="Redaktə">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.attendances.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                Bu tarix üçün davamiyyət qeydi yoxdur
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#attendancesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 50,
        ordering: true,
        searching: false,
        lengthChange: false
    });
});
</script>
@endpush
