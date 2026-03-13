@extends('layouts.app')

@section('title', 'Obyektlər')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Obyektlər</h1>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Yeni Obyekt
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="projectsTable">
                <thead>
                    <tr>
                        <th>Obyekt adı</th>
                        <th>Kod</th>
                        <th>Ünvan</th>
                        <th>Məsul şəxs</th>
                        <th>Başlanğıc</th>
                        <th>Bitmə</th>
                        <th>Status</th>
                        <th>İşçi sayı</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td><strong>{{ $project->name }}</strong></td>
                            <td><code>{{ $project->code }}</code></td>
                            <td>{{ Str::limit($project->address, 30) }}</td>
                            <td>{{ $project->manager_name ?? '-' }}</td>
                            <td>{{ $project->start_date?->format('d.m.Y') ?? '-' }}</td>
                            <td>{{ $project->end_date?->format('d.m.Y') ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $project->status_color }}">
                                    {{ $project->status_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $project->employees_count ?? 0 }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-info" title="Bax">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning" title="Redaktə">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                            <td colspan="9" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                Heç bir obyekt tapılmadı
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $projects->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#projectsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 25,
        ordering: true,
        searching: true
    });
});
</script>
@endpush
