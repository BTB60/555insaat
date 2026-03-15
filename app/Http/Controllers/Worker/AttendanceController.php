<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();
        
        $attendances = Attendance::where('employee_id', $employee?->id)
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        return view('employee.attendance', compact('attendances'));
    }
}
