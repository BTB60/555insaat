<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Advance;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();
        
        // Current month advance
        $current_advance = Advance::where('employee_id', $employee?->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');
        
        return view('employee.dashboard', compact('employee', 'current_advance'));
    }
}
