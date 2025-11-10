<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Employee\Auth\LoginController;
use App\Http\Controllers\Employee\AttendanceController;
use App\Http\Controllers\Admin\LeaveRequestController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePayrollController;
use App\Http\Controllers\PayrollController;

// Root redirect
Route::get('/', fn() => redirect()->route('employee.login'));

// Generic login fallback to fix RouteNotFoundException
Route::get('/login', fn() => redirect()->route('employee.login'))->name('login');

// Employee Auth Routes
Route::prefix('employee')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('employee.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('employee.logout');
});

// Employee Protected Routes
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/', fn() => redirect()->route('attendance.dashboard'));

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'showDashboard'])->name('attendance.dashboard');
    Route::post('/attendance/clock', [AttendanceController::class, 'clockAction'])->name('attendance.clock');
    Route::get('/attendance/history', [AttendanceController::class, 'showHistory'])->name('attendance.history');
    Route::get('/attendance/export', [AttendanceController::class, 'exportAttendance'])->name('attendance.export');

    // Payroll
    Route::get('/payroll', [EmployeePayrollController::class, 'index'])->name('employee.payroll.index');
    Route::get('/payroll/{payslip}', [EmployeePayrollController::class, 'show'])->name('employee.payroll.show');

    // Leave Requests
    Route::get('/leave', [LeaveRequestController::class, 'index'])->name('leave.index');
    Route::get('/leave/create', [LeaveRequestController::class, 'create'])->name('leave.create');
    Route::post('/leave', [LeaveRequestController::class, 'store'])->name('leave.store');
    Route::get('/leave/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('leave.show');
    Route::patch('/leave/{leaveRequest}/cancel', [LeaveRequestController::class, 'cancel'])->name('leave.cancel');
});

// Employee Profile & Creation
Route::get('/employeeCreation', [EmployeeController::class, 'employeeFormPage']);
Route::post('/test', [EmployeeController::class, 'employeeForm']);
Route::get('/signinPage', [EmployeeController::class, 'signinPage']);
Route::post('/employeeProfile', [EmployeeController::class, 'login'])->name('employee.login');
Route::get('/employeeProfile', [EmployeeController::class, 'employeeProfile'])->name('employee.profile');

// Edit Employee
Route::get('/editEmployee', [EmployeeController::class, 'viewEditEmployee']);
Route::post('/editEmployee', [EmployeeController::class, 'editEmployee']);

// Admin Routes
Route::prefix('admin')->group(function () {
    // Auth
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Protected Admin Routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/', fn() => redirect()->route('admin.dashboard'));
        Route::get('/returnToDash', [AdminController::class, 'dashboard'])->name('admin.dashboardMain');

        // Employee Management
        Route::get('/employeeList', [AdminController::class, 'showEmployees'])->name('admin.employeeList');
        Route::get('/employee/{id}/edit', [AdminController::class, 'showEditForm'])->name('admin.editForm');
        Route::put('/employee/{id}', [AdminController::class, 'updateEmployee'])->name('admin.employee.update');

    Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
        Route::patch('/leave-requests/{leaveRequest}/status', [LeaveRequestController::class, 'updateStatus'])->name('leave-requests.update-status');
    });

        // Payroll
        Route::get('/payroll', [PayrollController::class, 'index'])->name('admin.payroll.index');
        Route::get('/payroll/{employeeID}', [PayrollController::class, 'show'])->name('admin.payroll.show');
        Route::post('/payroll/process', [PayrollController::class, 'process'])->name('admin.payroll.process');
    });
});