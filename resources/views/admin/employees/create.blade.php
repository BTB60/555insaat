@extends('layouts.app')

@section('title', 'Yeni İşçi')
@section('subtitle', 'Yeni işçi əlavə et')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title">
        <h1>Yeni İşçi Əlavə Et</h1>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Geri
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Personal Info Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-person"></i> Şəxsi Məlumatlar
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="full_name">Ad Soyad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                               id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="father_name">Ata adı</label>
                        <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                               id="father_name" name="father_name" value="{{ old('father_name') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Telefon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" placeholder="+994 XX XXX XX XX">
                    </div>
                    
                    <div class="form-group">
                        <label for="identity_number">Ş/V nömrəsi</label>
                        <input type="text" class="form-control @error('identity_number') is-invalid @enderror" 
                               id="identity_number" name="identity_number" value="{{ old('identity_number') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="birth_date">Doğum tarixi</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                               id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="hire_date">İşə qəbul tarixi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('hire_date') is-invalid @enderror" 
                               id="hire_date" name="hire_date" value="{{ old('hire_date') }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">Ünvan</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="2">{{ old('address') }}</textarea>
                </div>
            </div>
            
            <!-- Work Info Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-briefcase"></i> İş Məlumatları
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="department">Şöbə</label>
                        <input type="text" class="form-control @error('department') is-invalid @enderror" 
                               id="department" name="department" value="{{ old('department') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="position">Vəzifə</label>
                        <input type="text" class="form-control @error('position') is-invalid @enderror" 
                               id="position" name="position" value="{{ old('position') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="project_id">Obyekt</label>
                        <select class="form-control @error('project_id') is-invalid @enderror" id="project_id" name="project_id">
                            <option value="">Seçin</option>
                            @foreach($projects ?? [] as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="salary_type">Maaş tipi <span class="text-danger">*</span></label>
                        <select class="form-control @error('salary_type') is-invalid @enderror" id="salary_type" name="salary_type" required>
                            <option value="monthly" {{ old('salary_type') == 'monthly' ? 'selected' : '' }}>Aylıq</option>
                            <option value="daily" {{ old('salary_type') == 'daily' ? 'selected' : '' }}>Günlük</option>
                            <option value="hourly" {{ old('salary_type') == 'hourly' ? 'selected' : '' }}>Saatlıq</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="salary_amount">Maaş məbləği (₼) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('salary_amount') is-invalid @enderror" 
                               id="salary_amount" name="salary_amount" value="{{ old('salary_amount') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="daily_salary">Günlük maaş (₼)</label>
                        <input type="number" step="0.01" class="form-control @error('daily_salary') is-invalid @enderror" 
                               id="daily_salary" name="daily_salary" value="{{ old('daily_salary', 0) }}">
                    </div>
                </div>
            </div>
            
            <!-- Photo Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-image"></i> Profil Şəkli
                </h3>
                
                <div class="form-group">
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                           id="photo" name="photo" accept="image/*" onchange="previewImage(this)">
                    <small class="form-text">Max: 2MB (JPG, PNG)</small>
                    <div class="mt-3">
                        <img id="photoPreview" src="#" alt="Preview" class="d-none" style="max-height: 150px; border-radius: 8px;">
                    </div>
                </div>
            </div>
            
            <!-- Notes -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-sticky"></i> Qeydlər
                </h3>
                
                <div class="form-group">
                    <textarea class="form-control @error('note') is-invalid @enderror" 
                              id="note" name="note" rows="3" placeholder="Əlavə qeydlər...">{{ old('note') }}</textarea>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save"></i> Yadda saxla
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Təmizlə
                </button>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Geri qayıt
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-section {
    margin-bottom: 32px;
    padding-bottom: 24px;
    border-bottom: 1px solid var(--gray-200);
}

.form-section:last-of-type {
    border-bottom: none;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-title i {
    font-size: 20px;
}

.form-actions {
    display: flex;
    gap: 12px;
    padding-top: 24px;
    border-top: 1px solid var(--gray-200);
}

.text-danger {
    color: var(--danger);
}
</style>
@endpush

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
