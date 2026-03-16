<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Advance;
use App\Models\Fine;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $employee = $user->employee;

        if (!$employee) {
            return view('worker.dashboard');
        }

        // Attendance stats for current month
        $attendanceStats = [
            'present' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'present')
                ->count(),
            'late' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'late')
                ->count(),
            'absent' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'absent')
                ->count(),
            'excused' => Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'excused')
                ->count(),
        ];

        // Work days (present + late)
        $workDays = $attendanceStats['present'] + $attendanceStats['late'];

        // Recent advances
        $recentAdvances = Advance::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $totalAdvances = Advance::where('employee_id', $employee->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->where('status', 'approved')
            ->sum('amount');

        // Recent fines
        $recentFines = Fine::where('employee_id', $employee->id)
            ->orderBy('fine_date', 'desc')
            ->limit(5)
            ->get();

        $totalFines = Fine::where('employee_id', $employee->id)
            ->whereMonth('fine_date', now()->month)
            ->whereYear('fine_date', now()->year)
            ->where('status', 'active')
            ->sum('amount');

        // Salary calculation
        $baseSalary = $employee->salary_amount ?? 0;
        $monthlySalary = $baseSalary;

        // Get current month salary if calculated
        $currentSalary = Salary::where('employee_id', $employee->id)
            ->where('year', now()->year)
            ->where('month', now()->month)
            ->first();

        if ($currentSalary) {
            $monthlySalary = $currentSalary->final_salary;
        }

        $salaryDetail = [
            'base' => $baseSalary,
            'advances' => $totalAdvances,
            'fines' => $totalFines,
            'total' => $monthlySalary - $totalAdvances - $totalFines,
        ];

        return view('worker.dashboard', compact(
            'attendanceStats',
            'workDays',
            'recentAdvances',
            'totalAdvances',
            'recentFines',
            'totalFines',
            'monthlySalary',
            'salaryDetail'
        ));
    }
}
