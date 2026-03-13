<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Advance;
use App\Models\Fine;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SalaryController extends Controller
{
    public function index(Request $request): View
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $salaries = Salary::with('employee')
            ->where('year', $year)
            ->where('month', $month)
            ->latest()
            ->paginate(25);

        $employees = Employee::active()->get();

        return view('admin.salaries.index', compact('salaries', 'employees', 'year', 'month'));
    }

    public function calculate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
        ]);

        $employee = Employee::find($validated['employee_id']);
        $year = $validated['year'];
        $month = $validated['month'];

        // Check if salary already calculated
        $existingSalary = Salary::where('employee_id', $employee->id)
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if ($existingSalary && $existingSalary->payment_status === 'paid') {
            return redirect()->back()->with('error', 'Bu ay üçün maaş artıq ödənilib.');
        }

        // Calculate attendance
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $presentDays = $attendances->whereIn('status', ['present', 'late'])->count();
        $halfDays = $attendances->where('status', 'half_day')->count();
        $absentDays = $attendances->where('status', 'absent')->count();

        // Calculate base salary based on attendance
        $totalWorkingDays = 26; // Standard working days
        $effectiveDays = $presentDays + ($halfDays * 0.5);
        
        if ($employee->salary_type === 'monthly') {
            $baseSalary = ($employee->salary_amount / $totalWorkingDays) * $effectiveDays;
        } elseif ($employee->salary_type === 'daily') {
            $baseSalary = $employee->daily_salary * $effectiveDays;
        } else {
            $baseSalary = $employee->hourly_salary * $effectiveDays * 8;
        }

        // Get advances for this month
        $advanceDeduction = Advance::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');

        // Get fines for this month
        $fineDeduction = Fine::where('employee_id', $employee->id)
            ->where('status', 'active')
            ->whereYear('fine_date', $year)
            ->whereMonth('fine_date', $month)
            ->sum('amount');

        // Create or update salary
        $salary = Salary::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'year' => $year,
                'month' => $month,
            ],
            [
                'base_salary' => round($baseSalary, 2),
                'bonus' => 0,
                'deduction' => 0,
                'advance_deduction' => round($advanceDeduction, 2),
                'fine_deduction' => round($fineDeduction, 2),
                'overtime_amount' => 0,
            ]
        );

        // Calculate final salary
        $salary->calculateFinalSalary();
        $salary->save();

        ActivityLog::log('calculate', 'salary', "Maaş hesablandı: {$employee->full_name}, {$month}/{$year}");

        return redirect()->route('admin.salaries.index', ['year' => $year, 'month' => $month])
            ->with('success', 'Maaş uğurla hesablandı.');
    }

    public function update(Request $request, Salary $salary): RedirectResponse
    {
        if ($salary->payment_status === 'paid') {
            return redirect()->back()->with('error', 'Ödənilmiş maaşı redaktə edə bilməzsiniz.');
        }

        $validated = $request->validate([
            'bonus' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'overtime_amount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        $salary->update($validated);
        $salary->calculateFinalSalary();
        $salary->save();

        ActivityLog::log('update', 'salary', "Maaş yeniləndi: {$salary->employee->full_name}");

        return redirect()->back()->with('success', 'Maaş məlumatları yeniləndi.');
    }

    public function pay(Salary $salary): RedirectResponse
    {
        if ($salary->payment_status === 'paid') {
            return redirect()->back()->with('error', 'Maaş artıq ödənilib.');
        }

        $salary->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        // Deduct advances
        Advance::where('employee_id', $salary->employee_id)
            ->where('status', 'approved')
            ->whereYear('date', $salary->year)
            ->whereMonth('date', $salary->month)
            ->update(['status' => 'deducted']);

        // Deduct fines
        Fine::where('employee_id', $salary->employee_id)
            ->where('status', 'active')
            ->whereYear('fine_date', $salary->year)
            ->whereMonth('fine_date', $salary->month)
            ->update(['status' => 'deducted']);

        ActivityLog::log('pay', 'salary', "Maaş ödənildi: {$salary->employee->full_name}, {$salary->month}/{$salary->year}");

        return redirect()->back()->with('success', 'Maaş ödənişi tamamlandı.');
    }

    public function show(Salary $salary): View
    {
        $salary->load('employee');
        return view('admin.salaries.show', compact('salary'));
    }
}
