<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Attendance::query();

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        } else {
            $query->where('date', today());
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $attendances = $query->with(['employee', 'project'])->latest()->paginate(50);
        $projects = Project::active()->get();
        $employees = Employee::active()->get();

        return view('admin.attendances.index', compact('attendances', 'projects', 'employees'));
    }

    public function create(Request $request): View
    {
        $date = $request->input('date', today()->format('Y-m-d'));
        $projectId = $request->input('project_id');

        $project = $projectId ? Project::find($projectId) : null;
        $employees = $project 
            ? $project->activeEmployees
            : Employee::active()->get();

        // Get existing attendances for this date
        $existingAttendances = Attendance::where('date', $date)
            ->pluck('status', 'employee_id')
            ->toArray();

        return view('admin.attendances.create', compact('date', 'project', 'employees', 'existingAttendances'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'project_id' => 'nullable|exists:projects,id',
            'attendances' => 'required|array',
            'attendances.*.employee_id' => 'required|exists:employees,id',
            'attendances.*.status' => 'required|in:present,late,absent,excused,vacation,sick,half_day',
            'attendances.*.check_in' => 'nullable',
            'attendances.*.check_out' => 'nullable',
            'attendances.*.note' => 'nullable|string',
        ]);

        $count = 0;
        foreach ($validated['attendances'] as $attendance) {
            // Update or create attendance
            Attendance::updateOrCreate(
                [
                    'employee_id' => $attendance['employee_id'],
                    'date' => $validated['date'],
                ],
                [
                    'project_id' => $validated['project_id'] ?? null,
                    'status' => $attendance['status'],
                    'check_in' => $attendance['check_in'] ?? null,
                    'check_out' => $attendance['check_out'] ?? null,
                    'note' => $attendance['note'] ?? null,
                ]
            );
            $count++;
        }

        ActivityLog::log('create', 'attendance', "Davamiyyət qeyd edildi: {$count} işçi, tarix: {$validated['date']}");

        return redirect()->route('admin.attendances.index', ['date' => $validated['date']])
            ->with('success', "{$count} işçi üçün davamiyyət qeyd edildi.");
    }

    public function show(Attendance $attendance): View
    {
        return view('admin.attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance): View
    {
        $projects = Project::active()->get();
        return view('admin.attendances.edit', compact('attendance', 'projects'));
    }

    public function update(Request $request, Attendance $attendance): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:present,late,absent,excused,vacation,sick,half_day',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'note' => 'nullable|string',
        ]);

        $attendance->update($validated);

        ActivityLog::log('update', 'attendance', "Davamiyyət yeniləndi: {$attendance->employee->full_name}, {$attendance->date}");

        return redirect()->route('admin.attendances.index')
            ->with('success', 'Davamiyyət məlumatı yeniləndi.');
    }

    public function destroy(Attendance $attendance): RedirectResponse
    {
        $attendance->delete();

        ActivityLog::log('delete', 'attendance', "Davamiyyət silindi");

        return redirect()->route('admin.attendances.index')
            ->with('success', 'Davamiyyət qeydi silindi.');
    }

    public function report(Request $request): View
    {
        $startDate = $request->input('start_date', today()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', today()->format('Y-m-d'));
        $projectId = $request->input('project_id');

        $query = Attendance::whereBetween('date', [$startDate, $endDate]);

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        $attendances = $query->with(['employee', 'project'])->get();

        // Summary statistics
        $summary = $attendances->groupBy('status')->map->count();

        $projects = Project::all();

        return view('admin.attendances.report', compact('attendances', 'summary', 'projects', 'startDate', 'endDate'));
    }
}
