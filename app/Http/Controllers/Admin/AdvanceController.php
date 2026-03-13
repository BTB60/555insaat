<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advance;
use App\Models\Employee;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdvanceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Advance::with('employee');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $advances = $query->latest()->paginate(25);
        $employees = Employee::active()->get();

        return view('admin.advances.index', compact('advances', 'employees'));
    }

    public function create(): View
    {
        $employees = Employee::active()->get();
        return view('admin.advances.create', compact('employees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'reason' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        $advance = Advance::create($validated);

        ActivityLog::log('create', 'advance', "Avans əlavə edildi: {$advance->employee->full_name}, {$advance->amount} AZN");

        return redirect()->route('admin.advances.index')
            ->with('success', 'Avans uğurla əlavə edildi.');
    }

    public function show(Advance $advance): View
    {
        return view('admin.advances.show', compact('advance'));
    }

    public function edit(Advance $advance): View
    {
        $employees = Employee::active()->get();
        return view('admin.advances.edit', compact('advance', 'employees'));
    }

    public function update(Request $request, Advance $advance): RedirectResponse
    {
        if ($advance->status === 'deducted') {
            return redirect()->back()->with('error', 'Çıxılmış avansı redaktə edə bilməzsiniz.');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'reason' => 'nullable|string|max:255',
            'status' => 'required|in:pending,approved',
            'note' => 'nullable|string',
        ]);

        $advance->update($validated);

        ActivityLog::log('update', 'advance', "Avans yeniləndi: {$advance->employee->full_name}");

        return redirect()->route('admin.advances.index')
            ->with('success', 'Avans məlumatları yeniləndi.');
    }

    public function destroy(Advance $advance): RedirectResponse
    {
        if ($advance->status === 'deducted') {
            return redirect()->back()->with('error', 'Çıxılmış avansı silə bilməzsiniz.');
        }

        $advance->delete();

        ActivityLog::log('delete', 'advance', "Avans silindi");

        return redirect()->route('admin.advances.index')
            ->with('success', 'Avans silindi.');
    }

    public function approve(Advance $advance): RedirectResponse
    {
        if ($advance->status !== 'pending') {
            return redirect()->back()->with('error', 'Yalnız gözləmədə olan avans təsdiqlənə bilər.');
        }

        $advance->update(['status' => 'approved']);

        ActivityLog::log('approve', 'advance', "Avans təsdiqləndi: {$advance->employee->full_name}");

        return redirect()->back()->with('success', 'Avans təsdiqləndi.');
    }
}
