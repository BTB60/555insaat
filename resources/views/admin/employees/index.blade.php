@extends('layouts.app')

@section('title', 'İşçilər')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">İşçilər</h1>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Yeni İşçi
    </a>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.employees.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" placeholder="Ad və ya soyad..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="phone" placeholder="Telefon..." value="{{ request('phone') }}">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="position">
                    <option value="">Vəzifə</option>
                    @foreach($positions as $position)
                        @if($position)
                            <option value="{{ $position }}" {{ request('position') == $position ? 'selected' : '' }}>
                                {{ $position }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="project_id">
                    <option value="">Obyekt</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktiv</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Deaktiv</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="employeesTable">
                <thead>
                    <tr>
                        <th>Şəkil</th>
                        <th>Ad Soyad</th>
                        <th>Telefon</th>
                        <th>Vəzifə</th>
                        <th>Şöbə</th>
                        <th>Obyekt</th>
                        <th>Maaş</th>
                        <th>Status</th>
                        <th>İşə qəbul</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>
                                @if($employee->photo)
                                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width:40px;height:40px">
                                        <i class="bi bi-person"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->phone ?? '-' }}</td>
                            <td>{{ $employee->position ?? '-' }}</td>
                            <td>{{ $employee->department ?? '-' }}</td>
                            <td>{{ $employee->currentProject()?->name ?? '-' }}</td>
                            <td>{{ number_format($employee->salary_amount, 2) }} AZN</td>
                            <td>
                                <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ $employee->status === 'active' ? 'Aktiv' : 'Deaktiv' }}
                                </span>
                            </td>
                            <td>{{ $employee->hire_date->format('d.m.Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-info" title="Bax">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-warning" title="Redaktə">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-success" title="Maaş hesabla" onclick="calculateSalary({{ $employee->id }})">
                                        <i class="bi bi-calculator"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary" title="Avans ver" onclick="giveAdvance({{ $employee->id }})">
                                        <i class="bi bi-cash"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" title="Cərimə yaz" onclick="giveFine({{ $employee->id }})">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </button>
                                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark" title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                Heç bir işçi tapılmadı
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#employeesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 25,
        ordering: true,
        searching: false,
        lengthChange: false
    });
});

function calculateSalary(employeeId) {
    window.location.href = '{{ route('admin.salaries.index') }}?employee_id=' + employeeId;
}

function giveAdvance(employeeId) {
    window.location.href = '{{ route('admin.advances.create') }}?employee_id=' + employeeId;
}

function giveFine(employeeId) {
    window.location.href = '{{ route('admin.fines.create') }}?employee_id=' + employeeId;
}
</script>
@endpush
