@extends('layouts.app')

@section('title', 'İşçilər')
@section('subtitle', 'Bütün işçilərin siyahısı və idarəetmə')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1>İşçilər</h1>
        <p>Ümumi: {{ $employees->total() ?? 0 }} işçi</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-lg"></i> Yeni İşçi Əlavə Et
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.employees.index') }}" method="GET" class="filter-grid">
            <div class="form-group">
                <label>Axtarış</label>
                <input type="text" class="form-control" name="search" placeholder="Ad və ya soyad..." value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <label>Telefon</label>
                <input type="text" class="form-control" name="phone" placeholder="Telefon..." value="{{ request('phone') }}">
            </div>
            <div class="form-group">
                <label>Vəzifə</label>
                <select class="form-control" name="position">
                    <option value="">Hamısı</option>
                    @foreach($positions ?? [] as $position)
                        @if($position)
                            <option value="{{ $position }}" {{ request('position') == $position ? 'selected' : '' }}>
                                {{ $position }}
                            </option>
                        @endif
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
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktiv</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Deaktiv</option>
                </select>
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search"></i> Axtar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Employees Table -->
<div class="card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="60">Şəkil</th>
                    <th>Ad Soyad</th>
                    <th>Telefon</th>
                    <th>Vəzifə</th>
                    <th>Obyekt</th>
                    <th>Maaş</th>
                    <th>Status</th>
                    <th width="200">Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees ?? [] as $employee)
                    <tr>
                        <td>
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="" class="avatar" style="width:40px;height:40px;">
                            @else
                                <div class="avatar" style="width:40px;height:40px;background:var(--gray-400);">
                                    {{ substr($employee->full_name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $employee->full_name }}</strong>
                            <small class="d-block text-muted">{{ $employee->department ?? '-' }}</small>
                        </td>
                        <td>{{ $employee->phone ?? '-' }}</td>
                        <td>{{ $employee->position ?? '-' }}</td>
                        <td>{{ $employee->currentProject()?->name ?? '-' }}</td>
                        <td>{{ number_format($employee->salary_amount, 2) }} ₼</td>
                        <td>
                            <span class="badge badge-{{ $employee->status === 'active' ? 'success' : 'secondary' }}">
                                {{ $employee->status === 'active' ? 'Aktiv' : 'Deaktiv' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-sm btn-info" title="Bax">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-warning" title="Redaktə">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-success" title="Maaş" onclick="location.href='{{ route('admin.salaries.index') }}?employee_id={{ $employee->id }}'">
                                    <i class="bi bi-calculator"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" title="Avans" onclick="location.href='{{ route('admin.advances.create') }}?employee_id={{ $employee->id }}'">
                                    <i class="bi bi-cash"></i>
                                </button>
                                <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Sil">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size:48px;color:var(--gray-400);"></i>
                            <p class="mt-3 text-muted">Heç bir işçi tapılmadı</p>
                            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-lg"></i> Yeni İşçi Əlavə Et
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(($employees ?? collect())->hasPages())
    <div class="card-footer">
        {{ $employees->links() }}
    </div>
    @endif
</div>

<!-- Floating Add Button for Mobile -->
<a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-floating d-md-none" title="Yeni İşçi Əlavə Et">
    <i class="bi bi-plus-lg"></i>
</a>
@endsection

@push('styles')
<style>
.btn-floating {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    z-index: 1000;
    font-size: 24px;
}

.btn-floating:hover {
    transform: scale(1.1);
}
</style>
@endpush

@push('styles')
<style>
.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    align-items: end;
}

.btn-group {
    display: flex;
    gap: 4px;
}

.btn-group .btn {
    padding: 6px 10px;
}

.data-table td {
    vertical-align: middle;
}
</style>
@endpush
