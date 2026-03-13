@extends('layouts.app')

@section('title', 'Fayllar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Fayl və Sənədlər</h1>
    <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
        <i class="bi bi-upload"></i> Fayl Yüklə
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="documentsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlıq</th>
                        <th>Kateqoriya</th>
                        <th>Tip</th>
                        <th>Həcm</th>
                        <th>Yükləyən</th>
                        <th>Tarix</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        <tr>
                            <td>{{ $document->id }}</td>
                            <td>{{ $document->title }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $document->category_label }}</span>
                            </td>
                            <td>{{ $document->file_type }}</td>
                            <td>{{ $document->file_size_formatted }}</td>
                            <td>{{ $document->uploadedBy?->name ?? '-' }}</td>
                            <td>{{ $document->created_at->format('d.m.Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.documents.show', $document) }}" class="btn btn-info" title="Bax">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-success" title="Yüklə">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                            <td colspan="8" class="text-center">Heç bir fayl tapılmadı</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $documents->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#documentsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 25
    });
});
</script>
@endpush
