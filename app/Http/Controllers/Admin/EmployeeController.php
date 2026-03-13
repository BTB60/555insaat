<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Employee::query();

        // Filters
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }
        if ($request->filled('project_id')) {
            $query->whereHas('projects', function ($q) use ($request) {
                $q->where('projects.id', $request->project_id);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $employees = $query->latest()->paginate(25);
        $projects = Project::active()->get();
        $positions = Employee::select('position')->distinct()->pluck('position');

        return view('admin.employees.index', compact('employees', 'projects', 'positions'));
    }

    public function create(): View
    {
        $projects = Project::active()->get();
        return view('admin.employees.create', compact('projects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'identity_number' => 'nullable|string|unique:employees',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'salary_type' => 'required|in:monthly,daily,hourly',
            'salary_amount' => 'required|numeric|min:0',
            'daily_salary' => 'nullable|numeric|min:0',
            'hourly_salary' => 'nullable|numeric|min:0',
            'hire_date' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'note' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee = Employee::create($validated);

        // Assign to project if selected
        if ($request->filled('project_id')) {
            $employee->projects()->attach($request->project_id, [
                'assigned_at' => now(),
                'status' => 'active',
            ]);
        }

        // Log activity
        ActivityLog::log('create', 'employee', "İşçi əlavə edildi: {$employee->full_name}");

        return redirect()->route('admin.employees.index')
            ->with('success', 'İşçi uğurla əlavə edildi.');
    }

    public function show(Employee $employee): View
    {
        $employee->load(['projects', 'attendances' => function ($q) {
            $q->latest()->limit(10);
        }, 'salaries' => function ($q) {
            $q->latest()->limit(10);
        }, 'advances' => function ($q) {
            $q->latest()->limit(5);
        }, 'fines' => function ($q) {
            $q->latest()->limit(5);
        }, 'documents']);

        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        $projects = Project::active()->get();
        return view('admin.employees.edit', compact('employee', 'projects'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'identity_number' => 'nullable|string|unique:employees,identity_number,' . $employee->id,
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'salary_type' => 'required|in:monthly,daily,hourly',
            'salary_amount' => 'required|numeric|min:0',
            'daily_salary' => 'nullable|numeric|min:0',
            'hourly_salary' => 'nullable|numeric|min:0',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|max:2048',
            'note' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee->update($validated);

        ActivityLog::log('update', 'employee', "İşçi yeniləndi: {$employee->full_name}");

        return redirect()->route('admin.employees.index')
            ->with('success', 'İşçi məlumatları yeniləndi.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        // Delete photo
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $name = $employee->full_name;
        $employee->delete();

        ActivityLog::log('delete', 'employee', "İşçi silindi: {$name}");

        return redirect()->route('admin.employees.index')
            ->with('success', 'İşçi silindi.');
    }

    public function assignProject(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
        ]);

        // End current assignment
        $employee->projects()->updateExistingPivot(
            $employee->projects()->wherePivot('status', 'active')->pluck('projects.id'),
            ['status' => 'completed']
        );

        // Create new assignment
        $employee->projects()->attach($validated['project_id'], [
            'assigned_at' => now(),
            'status' => 'active',
        ]);

        ActivityLog::log('assign', 'employee', "İşçi obyektə təyin edildi: {$employee->full_name}");

        return redirect()->back()->with('success', 'Obyektə təyin edildi.');
    }
}
