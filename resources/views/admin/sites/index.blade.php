@extends('layouts.app')

@section('title', 'Obyektlər')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Obyektlər</h1>
    <a href="{{ route('admin.sites.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Yeni Obyekt
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="sitesTable">
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
                    @forelse($sites as $site)
                        <tr>
                            <td>{{ $site->name }}</td>
                            <td>{{ $site->code }}</td>
                            <td>{{ Str::limit($site->address, 30) }}</td>
                            <td>{{ $site->manager?->name ?? '-' }}</td>
                            <td>{{ $site->start_date?->format('d.m.Y') ?? '-' }}</td>
                            <td>{{ $site->end_date?->format('d.m.Y') ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $site->status === 'active' ? 'success' : ($site->status === 'completed' ? 'info' : 'secondary') }}">
                                    {{ $site->status === 'active' ? 'Aktiv' : ($site->status === 'completed' ? 'Tamamlanmış' : ($site->status === 'on_hold' ? 'Dayandırılmış' : 'Ləğv edilmiş')) }}
                                </span>
                            </td>
                            <td>{{ $site->worker_count }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.sites.show', $site) }}" class="btn btn-info" title="Bax">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.sites.edit', $site) }}" class="btn btn-warning" title="Redaktə">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.sites.destroy', $site) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                            <td colspan="9" class="text-center">Heç bir obyekt tapılmadı</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $sites->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#sitesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 25
    });
});
</script>
@endpush
