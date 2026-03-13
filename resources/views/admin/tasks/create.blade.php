@extends('layouts.app')

@section('title', 'Yeni Tapşırıq')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Yeni Tapşırıq</h1>
    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Geri
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.tasks.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="title" class="form-label">Tapşırıq adı *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="priority" class="form-label">Prioritet *</label>
                    <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Aşağı</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }} selected>Orta</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Yüksək</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Təcili</option>
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="site_id" class="form-label">Obyekt</label>
                    <select class="form-select @error('site_id') is-invalid @enderror" id="site_id" name="site_id">
                        <option value="">Seçin</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ old('site_id') == $site->id ? 'selected' : '' }}>
                                {{ $site->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('site_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="start_date" class="form-label">Başlanğıc tarixi</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                           id="start_date" name="start_date" value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="due_date" class="form-label">Son tarix</label>
                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                           id="due_date" name="due_date" value="{{ old('due_date') }}">
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Açıqlama</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">İşçilər</label>
                <div class="row">
                    @foreach($workers as $worker)
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       name="workers[]" value="{{ $worker->id }}" 
                                       id="worker_{{ $worker->id }}"
                                       {{ in_array($worker->id, old('workers', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="worker_{{ $worker->id }}">
                                    {{ $worker->user->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('workers')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Yadda saxla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
