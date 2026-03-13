<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Attendance;
use App\Models\Advance;
use App\Models\Salary;
use App\Models\Task;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistics
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::active()->count(),
            'active_projects' => Project::active()->count(),
            'today_present' => Attendance::where('date', today())
                ->whereIn('status', ['present', 'late'])
                ->count(),
            'pending_advances' => Advance::pending()->count(),
        ];

        // Attendance data for chart
        $attendanceData = [
            'present' => Attendance::whereMonth('date', now()->month)
                ->where('status', 'present')
                ->count(),
            'late' => Attendance::whereMonth('date', now()->month)
                ->where('status', 'late')
                ->count(),
            'absent' => Attendance::whereMonth('date', now()->month)
                ->where('status', 'absent')
                ->count(),
            'excused' => Attendance::whereMonth('date', now()->month)
                ->where('status', 'excused')
                ->count(),
            'vacation' => Attendance::whereMonth('date', now()->month)
                ->where('status', 'vacation')
                ->count(),
        ];

        // Recent activities
        $recentActivities = ActivityLog::recent(10)->get();

        // Pending tasks
        $pendingTasks = Task::pending()->orWhere->inProgress()
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        // Salary stats for current month
        $salaryStats = [
            'calculated' => Salary::forMonth(now()->year, now()->month)->count(),
            'pending' => Salary::forMonth(now()->year, now()->month)->pending()->count(),
            'paid' => Salary::forMonth(now()->year, now()->month)->paid()->count(),
            'total_amount' => Salary::forMonth(now()->year, now()->month)->sum('final_salary'),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'attendanceData',
            'recentActivities',
            'pendingTasks',
            'salaryStats'
        ));
    }
}
