<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FineController extends Controller
{
    public function index(Request $request): View
    {
        $query = Fine::with(['employee', 'project']);

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $fines = $query->latest()->paginate(25);
        $employees = Employee::active()->get();
        $projects = Project::active()->get();

        return view('admin.fines.index', compact('fines', 'employees', 'projects'));
    }

    public function create(): View
    {
        $employees = Employee::active()->get();
        $projects = Project::active()->get();
        return view('admin.fines.create', compact('employees', 'projects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'project_id' => 'nullable|exists:projects,id',
            'amount' => 'required|numeric|min:1',
            'reason' => 'required|string|max:255',
            'fine_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $validated['status'] = 'active';
        $validated['created_by'] = auth()->id();

        $fine = Fine::create($validated);

        ActivityLog::log('create', 'fine', "Cərimə yazıldı: {$fine->employee->full_name}, {$fine->amount} AZN");

        return redirect()->route('admin.fines.index')
            ->with('success', 'Cərimə uğurla əlavə edildi.');
    }

    public function show(Fine $fine): View
    {
        return view('admin.fines.show', compact('fine'));
    }

    public function edit(Fine $fine): View
    {
        $employees = Employee::active()->get();
        $projects = Project::active()->get();
        return view('admin.fines.edit', compact('fine', 'employees', 'projects'));
    }

    public function update(Request $request, Fine $fine): RedirectResponse
    {
        if ($fine->status === 'deducted') {
            return redirect()->back()->with('error', 'Çıxılmış cəriməni redaktə edə bilməzsiniz.');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'project_id' => 'nullable|exists:projects,id',
            'amount' => 'required|numeric|min:1',
            'reason' => 'required|string|max:255',
            'fine_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $fine->update($validated);

        ActivityLog::log('update', 'fine', "Cərimə yeniləndi: {$fine->employee->full_name}");

        return redirect()->route('admin.fines.index')
            ->with('success', 'Cərimə məlumatları yeniləndi.');
    }

    public function destroy(Fine $fine): RedirectResponse
    {
        if ($fine->status === 'deducted') {
            return redirect()->back()->with('error', 'Çıxılmış cəriməni silə bilməzsiniz.');
        }

        $fine->delete();

        ActivityLog::log('delete', 'fine', "Cərimə silindi");

        return redirect()->route('admin.fines.index')
            ->with('success', 'Cərimə silindi.');
    }

    public function cancel(Fine $fine): RedirectResponse
    {
        if ($fine->status === 'deducted') {
            return redirect()->back()->with('error', 'Çıxılmış cəriməni ləğv edə bilməzsiniz.');
        }

        $fine->update(['status' => 'cancelled']);

        ActivityLog::log('cancel', 'fine', "Cərimə ləğv edildi: {$fine->employee->full_name}");

        return redirect()->back()->with('success', 'Cərimə ləğv edildi.');
    }
}
