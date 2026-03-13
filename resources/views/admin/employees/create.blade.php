@extends('layouts.app')

@section('title', 'Yeni İşçi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Yeni İşçi Əlavə Et</h1>
    <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Geri
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <h5 class="mb-3 text-primary">
                        <i class="bi bi-person me-2"></i>Şəxsi Məlumatlar
                    </h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Ad Soyad *</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            @error('full_name')
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
                            <label for="phone" class="form-label">Telefon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" placeholder="+994 XX XXX XX XX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="identity_number" class="form-label">Ş/V nömrəsi</label>
                            <input type="text" class="form-control @error('identity_number') is-invalid @enderror" 
                                   id="identity_number" name="identity_number" value="{{ old('identity_number') }}">
                            @error('identity_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Doğum tarixi</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="hire_date" class="form-label">İşə qəbul tarixi *</label>
                            <input type="date" class="form-control @error('hire_date') is-invalid @enderror" 
                                   id="hire_date" name="hire_date" value="{{ old('hire_date') }}" required>
                            @error('hire_date')
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
                    <h5 class="mb-3 text-primary">
                        <i class="bi bi-image me-2"></i>Şəkil
                    </h5>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Profil şəkli</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                               id="photo" name="photo" accept="image/*" onchange="previewImage(this)">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Max: 2MB (JPG, PNG)</div>
                        <div class="mt-2">
                            <img id="photoPreview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-height: 150px;">
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <h5 class="mb-3 text-primary">
                <i class="bi bi-briefcase me-2"></i>İş Məlumatları
            </h5>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="department" class="form-label">Şöbə</label>
                    <input type="text" class="form-control @error('department') is-invalid @enderror" 
                           id="department" name="department" value="{{ old('department') }}">
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="position" class="form-label">Vəzifə</label>
                    <input type="text" class="form-control @error('position') is-invalid @enderror" 
                           id="position" name="position" value="{{ old('position') }}">
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="project_id" class="form-label">Obyekt</label>
                    <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id">
                        <option value="">Seçin</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
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
                    <label for="salary_amount" class="form-label">Maaş məbləği (AZN) *</label>
                    <input type="number" step="0.01" class="form-control @error('salary_amount') is-invalid @enderror" 
                           id="salary_amount" name="salary_amount" value="{{ old('salary_amount') }}" required>
                    @error('salary_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="daily_salary" class="form-label">Günlük maaş (AZN)</label>
                    <input type="number" step="0.01" class="form-control @error('daily_salary') is-invalid @enderror" 
                           id="daily_salary" name="daily_salary" value="{{ old('daily_salary') }}">
                    @error('daily_salary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="note" class="form-label">Qeydlər</label>
                <textarea class="form-control @error('note') is-invalid @enderror" 
                          id="note" name="note" rows="3">{{ old('note') }}</textarea>
                @error('note')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Yadda saxla
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Təmizlə
                </button>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Geri qayıt
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('photoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
