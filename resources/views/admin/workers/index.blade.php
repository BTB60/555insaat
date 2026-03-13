@extends('layouts.app')

@section('title', 'İşçilər')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">İşçilər</h1>
    <a href="{{ route('admin.workers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Yeni İşçi
    </a>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.workers.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" placeholder="Ad və ya soyad..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="phone" placeholder="Telefon..." value="{{ request('phone') }}">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="position_id">
                    <option value="">Vəzifə</option>
                    @foreach(\App\Models\Position::active()->get() as $position)
                        <option value="{{ $position->id }}" {{ request('position_id') == $position->id ? 'selected' : '' }}>
                            {{ $position->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="site_id">
                    <option value="">Obyekt</option>
                    @foreach(\App\Models\Site::active()->get() as $site)
                        <option value="{{ $site->id }}" {{ request('site_id') == $site->id ? 'selected' : '' }}>
                            {{ $site->name }}
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
            <table class="table table-hover" id="workersTable">
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
                    @forelse($workers as $worker)
                        <tr>
                            <td>
                                @if($worker->user->photo)
                                    <img src="{{ asset('storage/' . $worker->user->photo) }}" alt="" class="rounded-circle" width="40" height="40">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width:40px;height:40px">
                                        <i class="bi bi-person"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $worker->user->name }}</td>
                            <td>{{ $worker->user->phone ?? '-' }}</td>
                            <td>{{ $worker->position?->name ?? '-' }}</td>
                            <td>{{ $worker->department?->name ?? '-' }}</td>
                            <td>{{ $worker->currentSite()?->name ?? '-' }}</td>
                            <td>{{ number_format($worker->base_salary, 2) }} AZN</td>
                            <td>
                                <span class="badge bg-{{ $worker->user->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ $worker->user->status === 'active' ? 'Aktiv' : 'Deaktiv' }}
                                </span>
                            </td>
                            <td>{{ $worker->hire_date->format('d.m.Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.workers.show', $worker) }}" class="btn btn-info" title="Bax">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.workers.edit', $worker) }}" class="btn btn-warning" title="Redaktə">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-success" title="Maaş hesabla" onclick="alert('Maaş hesablama funksiyası')">
                                        <i class="bi bi-calculator"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary" title="Avans ver" onclick="alert('Avans funksiyası')">
                                        <i class="bi bi-cash"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" title="Cərimə yaz" onclick="alert('Cərimə funksiyası')">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </button>
                                    <form action="{{ route('admin.workers.destroy', $worker) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                            <td colspan="10" class="text-center">Heç bir işçi tapılmadı</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $workers->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#workersTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 25,
        ordering: true
    });
});
</script>
@endpush
