@extends('layouts.app')

@section('title', $worker->user->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">İşçi Detalları</h1>
    <div>
        <a href="{{ route('admin.workers.edit', $worker) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Redaktə
        </a>
        <a href="{{ route('admin.workers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Geri
        </a>
    </div>
</div>

<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                @if($worker->user->photo)
                    <img src="{{ asset('storage/' . $worker->user->photo) }}" alt="" class="rounded-circle mb-3" width="120" height="120">
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white mx-auto mb-3" style="width:120px;height:120px">
                        <i class="bi bi-person fs-1"></i>
                    </div>
                @endif
                <h4>{{ $worker->user->name }}</h4>
                <p class="text-muted mb-1">{{ $worker->position?->name ?? 'Vəzifə təyin edilməyib' }}</p>
                <p class="text-muted">{{ $worker->department?->name ?? '-' }}</p>
                
                <hr>
                
                <div class="text-start">
                    <p class="mb-1"><strong>Email:</strong> {{ $worker->user->email }}</p>
                    <p class="mb-1"><strong>Telefon:</strong> {{ $worker->user->phone ?? '-' }}</p>
                    <p class="mb-1"><strong>Ş/V:</strong> {{ $worker->user->id_number ?? '-' }}</p>
                    <p class="mb-1"><strong>Doğum tarixi:</strong> {{ $worker->user->birth_date?->format('d.m.Y') ?? '-' }}</p>
                    <p class="mb-1"><strong>Ünvan:</strong> {{ $worker->user->address ?? '-' }}</p>
                    <p class="mb-1"><strong>İşə qəbul:</strong> {{ $worker->hire_date->format('d.m.Y') }}</p>
                    <p class="mb-0"><strong>Status:</strong> 
                        <span class="badge bg-{{ $worker->user->status === 'active' ? 'success' : 'secondary' }}">
                            {{ $worker->user->status === 'active' ? 'Aktiv' : 'Deaktiv' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Salary Info -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Maaş Məlumatları</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Maaş tipi:</strong> {{ $worker->salary_type === 'monthly' ? 'Aylıq' : ($worker->salary_type === 'daily' ? 'Günlük' : 'Saatlıq') }}</p>
                <p class="mb-1"><strong>Baza maaş:</strong> {{ number_format($worker->base_salary, 2) }} AZN</p>
                <p class="mb-0"><strong>Günlük maaş:</strong> {{ number_format($worker->daily_salary, 2) }} AZN</p>
            </div>
        </div>
    </div>
    
    <!-- Details Tabs -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="workerTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="site-tab" data-bs-toggle="tab" data-bs-target="#site" type="button" role="tab">
                            Obyekt
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">
                            Davamiyyət
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary" type="button" role="tab">
                            Maaşlar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                            Sənədlər
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance" type="button" role="tab">
                            Avans/Cərimə
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="workerTabsContent">
                    <!-- Site Tab -->
                    <div class="tab-pane fade show active" id="site" role="tabpanel">
                        <h6>Cari Obyekt</h6>
                        @if($worker->currentSite())
                            <p><strong>{{ $worker->currentSite()->name }}</strong></p>
                            <p>{{ $worker->currentSite()->address }}</p>
                        @else
                            <p class="text-muted">Obyekt təyin edilməyib</p>
                        @endif
                        
                        <h6 class="mt-4">Obyekt Tarixçəsi</h6>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Obyekt</th>
                                    <th>Təyin tarixi</th>
                                    <th>Bitmə tarixi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($worker->assignments as $assignment)
                                    <tr>
                                        <td>{{ $assignment->site->name }}</td>
                                        <td>{{ $assignment->assigned_date->format('d.m.Y') }}</td>
                                        <td>{{ $assignment->end_date?->format('d.m.Y') ?? '-' }}</td>
                                        <td>{{ $assignment->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Məlumat yoxdur</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Attendance Tab -->
                    <div class="tab-pane fade" id="attendance" role="tabpanel">
                        <h6>Son Davamiyyət</h6>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tarix</th>
                                    <th>Status</th>
                                    <th>Giriş</th>
                                    <th>Çıxış</th>
                                    <th>İş saatı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($worker->attendances()->latest()->limit(10)->get() as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('d.m.Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'absent' ? 'danger' : 'warning') }}">
                                                {{ $attendance->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->check_in ?? '-' }}</td>
                                        <td>{{ $attendance->check_out ?? '-' }}</td>
                                        <td>{{ $attendance->work_hours ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Məlumat yoxdur</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Salary Tab -->
                    <div class="tab-pane fade" id="salary" role="tabpanel">
                        <h6>Maaş Tarixçəsi</h6>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>İl/Ay</th>
                                    <th>Baza</th>
                                    <th>Bonus</th>
                                    <th>Kəsinti</th>
                                    <th>Yekun</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($worker->salaries()->latest()->limit(10)->get() as $salary)
                                    <tr>
                                        <td>{{ $salary->year }}/{{ $salary->month }}</td>
                                        <td>{{ number_format($salary->base_amount, 2) }}</td>
                                        <td>{{ number_format($salary->bonus, 2) }}</td>
                                        <td>{{ number_format($salary->total_deductions, 2) }}</td>
                                        <td>{{ number_format($salary->net_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $salary->status === 'paid' ? 'success' : ($salary->status === 'approved' ? 'info' : 'warning') }}">
                                                {{ $salary->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Məlumat yoxdur</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Documents Tab -->
                    <div class="tab-pane fade" id="documents" role="tabpanel">
                        <h6>Sənədlər</h6>
                        <div class="list-group">
                            @forelse($worker->documents as $document)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $document->title }}</h6>
                                        <small class="text-muted">{{ $document->category_label }} - {{ $document->created_at->format('d.m.Y') }}</small>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item text-center text-muted">Sənəd yoxdur</div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Finance Tab -->
                    <div class="tab-pane fade" id="finance" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Avanslar</h6>
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tarix</th>
                                            <th>Məbləğ</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($worker->advances()->latest()->limit(5)->get() as $advance)
                                            <tr>
                                                <td>{{ $advance->date->format('d.m.Y') }}</td>
                                                <td>{{ number_format($advance->amount, 2) }} AZN</td>
                                                <td>{{ $advance->status_label }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Məlumat yoxdur</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6>Cərimələr</h6>
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tarix</th>
                                            <th>Məbləğ</th>
                                            <th>Səbəb</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($worker->penalties()->latest()->limit(5)->get() as $penalty)
                                            <tr>
                                                <td>{{ $penalty->date->format('d.m.Y') }}</td>
                                                <td>{{ number_format($penalty->amount, 2) }} AZN</td>
                                                <td>{{ $penalty->reason_label }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Məlumat yoxdur</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
