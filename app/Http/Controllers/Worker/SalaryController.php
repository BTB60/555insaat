<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalaryController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();
        
        $salaries = Salary::where('employee_id', $employee?->id)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(12);
        
        return view('employee.salary', compact('salaries'));
    }
}
