<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Employee;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::withCount(['employees' => function ($q) {
            $q->where('employee_project.status', 'active');
        }])->latest()->paginate(25);

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:projects|max:50',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,completed,on_hold,cancelled',
            'note' => 'nullable|string',
        ]);

        $project = Project::create($validated);

        ActivityLog::log('create', 'project', "Obyekt əlavə edildi: {$project->name}");

        return redirect()->route('admin.projects.index')
            ->with('success', 'Obyekt uğurla əlavə edildi.');
    }

    public function show(Project $project): View
    {
        $project->load(['employees' => function ($q) {
            $q->where('employee_project.status', 'active');
        }, 'tasks' => function ($q) {
            $q->latest()->limit(10);
        }]);

        // Calculate attendance stats
        $attendanceStats = $project->attendances()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Calculate salary expenses for current month
        $salaryExpenses = $project->employees()
            ->join('salaries', 'employees.id', '=', 'salaries.employee_id')
            ->where('salaries.year', now()->year)
            ->where('salaries.month', now()->month)
            ->sum('salaries.final_salary');

        return view('admin.projects.show', compact('project', 'attendanceStats', 'salaryExpenses'));
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:projects,code,' . $project->id . '|max:50',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,completed,on_hold,cancelled',
            'note' => 'nullable|string',
        ]);

        $project->update($validated);

        ActivityLog::log('update', 'project', "Obyekt yeniləndi: {$project->name}");

        return redirect()->route('admin.projects.index')
            ->with('success', 'Obyekt məlumatları yeniləndi.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $name = $project->name;
        $project->delete();

        ActivityLog::log('delete', 'project', "Obyekt silindi: {$name}");

        return redirect()->route('admin.projects.index')
            ->with('success', 'Obyekt silindi.');
    }

    public function assignEmployees(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        foreach ($validated['employee_ids'] as $employeeId) {
            // End current assignment for employee
            Employee::find($employeeId)->projects()
                ->wherePivot('status', 'active')
                ->updateExistingPivot($project->id, ['status' => 'completed']);

            // Create new assignment
            $project->employees()->attach($employeeId, [
                'assigned_at' => now(),
                'status' => 'active',
            ]);
        }

        ActivityLog::log('assign', 'project', "İşçilər obyektə təyin edildi: {$project->name}");

        return redirect()->back()->with('success', 'İşçilər obyektə təyin edildi.');
    }
}
