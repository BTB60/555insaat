<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\Attendance;
use App\Models\Salary;
use App\Models\Advance;
use App\Models\Penalty;
use App\Models\Site;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkersExport;
use App\Exports\AttendanceExport;
use App\Exports\SalaryExport;

class ReportController extends Controller
{
    public function index(): View
    {
        $sites = Site::active()->get();
        $workers = Worker::with('user')->active()->get();
        
        return view('admin.reports.index', compact('sites', 'workers'));
    }

    public function workersReport(Request $request): View
    {
        $query = Worker::with(['user', 'department', 'position', 'sites']);
        
        if ($request->has('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        
        if ($request->has('site_id')) {
            $query->whereHas('sites', function ($q) use ($request) {
                $q->where('sites.id', $request->site_id);
            });
        }
        
        if ($request->has('status')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        
        $workers = $query->get();
        
        if ($request->has('export')) {
            return $this->exportWorkers($workers, $request->export);
        }
        
        return view('admin.reports.workers', compact('workers'));
    }

    public function attendanceReport(Request $request): View
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'worker_id' => 'nullable|exists:workers,id',
            'site_id' => 'nullable|exists:sites,id',
        ]);

        $query = Attendance::with(['worker.user', 'site'])
            ->whereBetween('date', [$validated['start_date'], $validated['end_date']]);
        
        if ($request->has('worker_id')) {
            $query->where('worker_id', $request->worker_id);
        }
        
        if ($request->has('site_id')) {
            $query->where('site_id', $request->site_id);
        }
        
        $attendances = $query->get();
        
        // Calculate statistics
        $stats = [
            'total_days' => $attendances->count(),
            'present' => $attendances->whereIn('status', ['present', 'late', 'half_day'])->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'excused' => $attendances->whereIn('status', ['excused', 'vacation', 'sick'])->count(),
        ];
        
        if ($request->has('export')) {
            return $this->exportAttendance($attendances, $request->export);
        }
        
        return view('admin.reports.attendance', compact('attendances', 'stats'));
    }

    public function salaryReport(Request $request): View
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
            'worker_id' => 'nullable|exists:workers,id',
        ]);

        $query = Salary::with(['worker.user', 'calculatedBy'])
            ->where('year', $validated['year'])
            ->where('month', $validated['month']);
        
        if ($request->has('worker_id')) {
            $query->where('worker_id', $request->worker_id);
        }
        
        $salaries = $query->get();
        
        // Calculate totals
        $totals = [
            'base_amount' => $salaries->sum('base_amount'),
            'overtime_amount' => $salaries->sum('overtime_amount'),
            'bonus' => $salaries->sum('bonus'),
            'advance_deduction' => $salaries->sum('advance_deduction'),
            'penalty_deduction' => $salaries->sum('penalty_deduction'),
            'net_amount' => $salaries->sum('net_amount'),
        ];
        
        if ($request->has('export')) {
            return $this->exportSalary($salaries, $request->export);
        }
        
        return view('admin.reports.salary', compact('salaries', 'totals'));
    }

    public function advancesReport(Request $request): View
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'worker_id' => 'nullable|exists:workers,id',
            'status' => 'nullable|in:pending,approved,rejected,deducted',
        ]);

        $query = Advance::with(['worker.user', 'approvedBy'])
            ->whereBetween('date', [$validated['start_date'], $validated['end_date']]);
        
        if ($request->has('worker_id')) {
            $query->where('worker_id', $request->worker_id);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $advances = $query->get();
        $total = $advances->sum('amount');
        
        return view('admin.reports.advances', compact('advances', 'total'));
    }

    public function penaltiesReport(Request $request): View
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'worker_id' => 'nullable|exists:workers,id',
            'site_id' => 'nullable|exists:sites,id',
        ]);

        $query = Penalty::with(['worker.user', 'site', 'issuedBy'])
            ->whereBetween('date', [$validated['start_date'], $validated['end_date']]);
        
        if ($request->has('worker_id')) {
            $query->where('worker_id', $request->worker_id);
        }
        
        if ($request->has('site_id')) {
            $query->where('site_id', $request->site_id);
        }
        
        $penalties = $query->get();
        $total = $penalties->sum('amount');
        
        return view('admin.reports.penalties', compact('penalties', 'total'));
    }

    public function tasksReport(Request $request): View
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'site_id' => 'nullable|exists:sites,id',
            'status' => 'nullable|in:pending,in_progress,completed,cancelled',
        ]);

        $query = Task::with(['site', 'createdBy', 'workers.user']);
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$validated['start_date'], $validated['end_date']]);
        }
        
        if ($request->has('site_id')) {
            $query->where('site_id', $request->site_id);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $tasks = $query->get();
        
        // Calculate statistics
        $stats = [
            'total' => $tasks->count(),
            'pending' => $tasks->where('status', 'pending')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
            'cancelled' => $tasks->where('status', 'cancelled')->count(),
            'overdue' => $tasks->where('is_overdue', true)->count(),
        ];
        
        return view('admin.reports.tasks', compact('tasks', 'stats'));
    }

    private function exportWorkers($workers, $format)
    {
        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('admin.reports.exports.workers_pdf', compact('workers'));
                return $pdf->download('isci_siyahisi_' . now()->format('Y-m-d') . '.pdf');
            
            case 'excel':
                return Excel::download(new WorkersExport($workers), 'isci_siyahisi_' . now()->format('Y-m-d') . '.xlsx');
            
            case 'csv':
                return Excel::download(new WorkersExport($workers), 'isci_siyahisi_' . now()->format('Y-m-d') . '.csv');
        }
    }

    private function exportAttendance($attendances, $format)
    {
        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('admin.reports.exports.attendance_pdf', compact('attendances'));
                return $pdf->download('davamiyyet_' . now()->format('Y-m-d') . '.pdf');
            
            case 'excel':
                return Excel::download(new AttendanceExport($attendances), 'davamiyyet_' . now()->format('Y-m-d') . '.xlsx');
            
            case 'csv':
                return Excel::download(new AttendanceExport($attendances), 'davamiyyet_' . now()->format('Y-m-d') . '.csv');
        }
    }

    private function exportSalary($salaries, $format)
    {
        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('admin.reports.exports.salary_pdf', compact('salaries'));
                return $pdf->download('maas_hesabati_' . now()->format('Y-m-d') . '.pdf');
            
            case 'excel':
                return Excel::download(new SalaryExport($salaries), 'maas_hesabati_' . now()->format('Y-m-d') . '.xlsx');
            
            case 'csv':
                return Excel::download(new SalaryExport($salaries), 'maas_hesabati_' . now()->format('Y-m-d') . '.csv');
        }
    }
}
