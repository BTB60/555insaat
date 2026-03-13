@extends('layouts.app')

@section('title', 'Tapşırıqlar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Tapşırıqlar</h1>
    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Yeni Tapşırıq
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="tasksTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlıq</th>
                        <th>Obyekt</th>
                        <th>Prioritet</th>
                        <th>Status</th>
                        <th>Son tarix</th>
                        <th>İşçilər</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr class="{{ $task->is_overdue ? 'table-danger' : '' }}">
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->site?->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning' : ($task->priority === 'medium' ? 'info' : 'secondary')) }}">
                                    {{ $task->priority_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'primary' : ($task->status === 'cancelled' ? 'secondary' : 'warning')) }}">
                                    {{ $task->status_label }}
                                </span>
                            </td>
                            <td>
                                {{ $task->due_date?->format('d.m.Y') ?? '-' }}
                                @if($task->is_overdue)
                                    <i class="bi bi-exclamation-circle text-danger" title="Gecikib"></i>
                                @endif
                            </td>
                            <td>{{ $task->workers->count() }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-info" title="Bax">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-warning" title="Redaktə">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
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
                            <td colspan="8" class="text-center">Heç bir tapşırıq tapılmadı</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $tasks->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tasksTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 25
    });
});
</script>
@endpush
