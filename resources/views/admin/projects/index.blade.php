@extends('layouts.app')

@section('title', 'Obyektlər')
@section('subtitle', 'İnşaat layihələrinin idarəetməsi')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1>Obyektlər</h1>
        <p>Ümumi: {{ ($projects ?? collect())->total() ?? 0 }} layihə</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-lg"></i> Yeni Obyekt Əlavə Et
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid three mb-4">
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="bi bi-building"></i>
        </div>
        <div class="stat-info">
            <h3>Aktiv Obyektlər</h3>
            <p class="stat-value">{{ ($projects ?? collect())->where('status', 'active')->count() ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="bi bi-clock"></i>
        </div>
        <div class="stat-info">
            <h3>Gözləyən</h3>
            <p class="stat-value">{{ ($projects ?? collect())->where('status', 'pending')->count() ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Tamamlanan</h3>
            <p class="stat-value">{{ ($projects ?? collect())->where('status', 'completed')->count() ?? 0 }}</p>
        </div>
    </div>
</div>

<!-- Projects Table -->
<div class="card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Obyekt</th>
                    <th>Ünvan</th>
                    <th>Məsul şəxs</th>
                    <th>Tarixlər</th>
                    <th>Status</th>
                    <th>İşçilər</th>
                    <th width="150">Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects ?? [] as $project)
                    <tr>
                        <td>
                            <strong>{{ $project->name }}</strong>
                            <small class="d-block text-muted">{{ $project->code }}</small>
                        </td>
                        <td>{{ Str::limit($project->address, 25) ?? '-' }}</td>
                        <td>{{ $project->manager_name ?? '-' }}</td>
                        <td>
                            <small>{{ $project->start_date?->format('d.m.Y') ?? '-' }} - {{ $project->end_date?->format('d.m.Y') ?? '-' }}</small>
                        </td>
                        <td>
                            @php
                                $statusColors = ['active' => 'success', 'pending' => 'warning', 'completed' => 'info', 'cancelled' => 'secondary'];
                                $statusLabels = ['active' => 'Aktiv', 'pending' => 'Gözləyir', 'completed' => 'Tamamlandı', 'cancelled' => 'Ləğv edildi'];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$project->status] ?? 'secondary' }}">
                                {{ $statusLabels[$project->status] ?? $project->status }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $project->employees_count ?? 0 }} işçi</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-info" title="Bax">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning" title="Redaktə">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-primary" title="İşçi təyin et" onclick="location.href='{{ route('admin.projects.show', $project) }}#employees'">
                                    <i class="bi bi-people"></i>
                                </button>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-building" style="font-size:48px;color:var(--gray-400);"></i>
                            <p class="mt-3 text-muted">Heç bir obyekt tapılmadı</p>
                            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-lg"></i> Yeni Obyekt Əlavə Et
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(($projects ?? collect())->hasPages())
    <div class="card-footer">
        {{ $projects->links() }}
    </div>
    @endif
</div>

<!-- Floating Add Button -->
<a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-floating d-md-none">
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
.stats-grid.three {
    grid-template-columns: repeat(3, 1fr);
}
@media (max-width: 768px) {
    .stats-grid.three {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
