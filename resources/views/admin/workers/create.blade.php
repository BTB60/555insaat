@extends('layouts.app')

@section('title', 'Yeni İşçi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Yeni İşçi Əlavə Et</h1>
    <div>
        <a href="{{ route('admin.workers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Geri
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.workers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <h5 class="mb-3">Şəxsi Məlumatlar</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Ad Soyad *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="father_name" class="form-label">Ata adı</label>
                            <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                                   id="father_name" name="father_name" value="{{ old('father_name') }}">
                            @error('father_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Telefon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_number" class="form-label">Ş/V nömrəsi</label>
                            <input type="text" class="form-control @error('id_number') is-invalid @enderror" 
                                   id="id_number" name="id_number" value="{{ old('id_number') }}">
                            @error('id_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Doğum tarixi</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Ünvan</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="2">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <h5 class="mb-3">Şəkil</h5>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Profil şəkli</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                               id="photo" name="photo" accept="image/*">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Max: 2MB (JPG, PNG)</div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <h5 class="mb-3">İş Məlumatları</h5>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="department_id" class="form-label">Şöbə</label>
                    <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                        <option value="">Seçin</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="position_id" class="form-label">Vəzifə</label>
                    <select class="form-select @error('position_id') is-invalid @enderror" id="position_id" name="position_id">
                        <option value="">Seçin</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('position_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
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
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="salary_type" class="form-label">Maaş tipi *</label>
                    <select class="form-select @error('salary_type') is-invalid @enderror" id="salary_type" name="salary_type" required>
                        <option value="monthly" {{ old('salary_type') == 'monthly' ? 'selected' : '' }}>Aylıq</option>
                        <option value="daily" {{ old('salary_type') == 'daily' ? 'selected' : '' }}>Günlük</option>
                        <option value="hourly" {{ old('salary_type') == 'hourly' ? 'selected' : '' }}>Saatlıq</option>
                    </select>
                    @error('salary_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="base_salary" class="form-label">Baza maaş (AZN) *</label>
                    <input type="number" step="0.01" class="form-control @error('base_salary') is-invalid @enderror" 
                           id="base_salary" name="base_salary" value="{{ old('base_salary') }}" required>
                    @error('base_salary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="hire_date" class="form-label">İşə qəbul tarixi *</label>
                    <input type="date" class="form-control @error('hire_date') is-invalid @enderror" 
                           id="hire_date" name="hire_date" value="{{ old('hire_date') }}" required>
                    @error('hire_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="notes" class="form-label">Qeydlər</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Yadda saxla
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Təmizlə
                </button>
                <a href="{{ route('admin.workers.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Geri qayıt
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
