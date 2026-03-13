@extends('layouts.app')

@section('title', 'Maaşlar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Maaşlar</h1>
    <div>
        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#calculateModal">
            <i class="bi bi-calculator"></i> Maaş Hesabla
        </button>
        <a href="{{ route('admin.reports.salary') }}" class="btn btn-outline-primary">
            <i class="bi bi-file-earmark-pdf"></i> Hesabat
        </a>
    </div>
</div>

<!-- Month/Year Filter -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.salaries.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">İl</label>
                <select class="form-select" name="year">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ay</label>
                <select class="form-select" name="month">
                    @foreach(['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'İyun', 'İyul', 'Avqust', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr'] as $index => $monthName)
                        <option value="{{ $index + 1 }}" {{ $month == $index + 1 ? 'selected' : '' }}>{{ $monthName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-2"></i>Göstər
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Ümumi Maaş</h6>
                <h3>{{ number_format($salaries->sum('final_salary'), 2) }} AZN</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6 class="card-title">Gözləyən</h6>
                <h3>{{ $salaries->where('payment_status', 'pending')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Ödənilmiş</h6>
                <h3>{{ $salaries->where('payment_status', 'paid')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Hesablanmış</h6>
                <h3>{{ $salaries->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="salariesTable">
                <thead>
                    <tr>
                        <th>İşçi</th>
                        <th>Baza Maaş</th>
                        <th>Bonus</th>
                        <th>Əlavə Saat</th>
                        <th>Avans</th>
                        <th>Cərimə</th>
                        <th>Yekun</th>
                        <th>Status</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salaries as $salary)
                        <tr>
                            <td>{{ $salary->employee->full_name }}</td>
                            <td>{{ number_format($salary->base_salary, 2) }}</td>
                            <td>{{ number_format($salary->bonus, 2) }}</td>
                            <td>{{ number_format($salary->overtime_amount, 2) }}</td>
                            <td class="text-danger">-{{ number_format($salary->advance_deduction, 2) }}</td>
                            <td class="text-danger">-{{ number_format($salary->fine_deduction, 2) }}</td>
                            <td><strong>{{ number_format($salary->final_salary, 2) }}</strong></td>
                            <td>
                                <span class="badge bg-{{ $salary->payment_status_color }}">
                                    {{ $salary->payment_status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($salary->payment_status === 'pending')
                                        <button type="button" class="btn btn-success" onclick="paySalary({{ $salary->id }})" title="Ödə">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $salary->id }}" title="Redaktə">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.salaries.show', $salary) }}" class="btn btn-info" title="Bax">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                Bu ay üçün maaş hesablanmayıb
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $salaries->links() }}
        </div>
    </div>
</div>

<!-- Calculate Modal -->
<div class="modal fade" id="calculateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Maaş Hesabla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.salaries.calculate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">İşçi</label>
                        <select class="form-select" name="employee_id" required>
                            <option value="">Seçin</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
                    <button type="submit" class="btn btn-primary">Hesabla</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#salariesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/az.json'
        },
        pageLength: 25,
        ordering: true,
        searching: true
    });
});

function paySalary(salaryId) {
    if(confirm('Maaşı ödədiyinizə əminsiniz?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/salaries/' + salaryId + '/pay';
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
