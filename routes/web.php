<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\AdvanceController;
use App\Http\Controllers\Admin\FineController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Worker\DashboardController as WorkerDashboardController;
use App\Http\Controllers\Worker\ProfileController;
use App\Http\Controllers\Worker\AttendanceController as WorkerAttendanceController;
use App\Http\Controllers\Worker\SalaryController as WorkerSalaryController;

// Public routes
Route::get('/', fn() => redirect('/login'));

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Admin routes
Route::middleware(['auth', 'role:super-admin|admin|accountant'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Employees
        Route::resource('employees', EmployeeController::class);
        Route::post('employees/{employee}/assign-project', [EmployeeController::class, 'assignProject'])->name('employees.assign-project');
        
        // Projects
        Route::resource('projects', ProjectController::class);
        Route::post('projects/{project}/assign-employees', [ProjectController::class, 'assignEmployees'])->name('projects.assign-employees');
        
        // Attendance
        Route::resource('attendances', AttendanceController::class);
        Route::get('attendance/daily', [AttendanceController::class, 'daily'])->name('attendance.daily');
        Route::post('attendance/bulk', [AttendanceController::class, 'bulkStore'])->name('attendance.bulk');
        
        // Salaries
        Route::resource('salaries', SalaryController::class);
        Route::get('salaries/calculate', [SalaryController::class, 'calculateForm'])->name('salaries.calculate-form');
        Route::post('salaries/calculate', [SalaryController::class, 'calculate'])->name('salaries.calculate');
        Route::post('salaries/{salary}/approve', [SalaryController::class, 'approve'])->name('salaries.approve');
        Route::post('salaries/{salary}/pay', [SalaryController::class, 'pay'])->name('salaries.pay');
        Route::get('salaries/{salary}/pdf', [SalaryController::class, 'downloadPdf'])->name('salaries.pdf');
        
        // Advances
        Route::resource('advances', AdvanceController::class);
        Route::post('advances/{advance}/approve', [AdvanceController::class, 'approve'])->name('advances.approve');
        Route::post('advances/{advance}/reject', [AdvanceController::class, 'reject'])->name('advances.reject');
        
        // Fines
        Route::resource('fines', FineController::class);
        Route::post('fines/{fine}/cancel', [FineController::class, 'cancel'])->name('fines.cancel');
        
        // Tasks
        Route::resource('tasks', TaskController::class);
        Route::post('tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
        
        // Documents
        Route::resource('documents', DocumentController::class);
        Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
        Route::get('documents/employee/{employee}', [DocumentController::class, 'byEmployee'])->name('documents.by-employee');
        Route::get('documents/project/{project}', [DocumentController::class, 'byProject'])->name('documents.by-project');
        
        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/workers', [ReportController::class, 'workersReport'])->name('reports.workers');
        Route::get('reports/attendance', [ReportController::class, 'attendanceReport'])->name('reports.attendance');
        Route::get('reports/salary', [ReportController::class, 'salaryReport'])->name('reports.salary');
        Route::get('reports/advances', [ReportController::class, 'advancesReport'])->name('reports.advances');
        Route::get('reports/fines', [ReportController::class, 'finesReport'])->name('reports.fines');
        Route::get('reports/tasks', [ReportController::class, 'tasksReport'])->name('reports.tasks');
    });

// Worker panel routes
Route::middleware(['auth', 'role:worker'])
    ->prefix('worker')
    ->name('worker.')
    ->group(function () {
        Route::get('/dashboard', [WorkerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::get('/attendances', [WorkerAttendanceController::class, 'index'])->name('attendances');
        Route::get('/salaries', [WorkerSalaryController::class, 'index'])->name('salaries');
        Route::get('/salaries/{salary}/pdf', [WorkerSalaryController::class, 'downloadPdf'])->name('salaries.pdf');
    });
