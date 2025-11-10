<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Employee\Auth\LoginController;
use App\Http\Controllers\Employee\AttendanceController;
use App\Http\Controllers\Employee\LeaveRequestController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePayrollController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Http\Controllers\EmployeeController;


Route::prefix('employee')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('employee.login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::post('/logout', [LoginController::class, 'logout'])->name('employee.logout');
});

Route::middleware(['auth:employee'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('attendance.dashboard');
    });

    Route::get('/attendance', [AttendanceController::class, 'showDashboard'])->name('attendance.dashboard');
    Route::post('/attendance/clock', [AttendanceController::class, 'clockAction'])->name('attendance.clock');
    Route::get('/attendance/history', [AttendanceController::class, 'showHistory'])->name('attendance.history');
    Route::get('/attendance/export', [AttendanceController::class, 'exportAttendance'])->name('attendance.export');

    // Employee Payroll Routes
    Route::get('/payroll', [EmployeePayrollController::class, 'index'])->name('employee.payroll.index');
    Route::get('/payroll/{payslip}', [EmployeePayrollController::class, 'show'])->name('employee.payroll.show');

    // Leave Request Routes
    Route::get('/leave', [LeaveRequestController::class, 'index'])->name('leave.index');
    Route::get('/leave/create', [LeaveRequestController::class, 'create'])->name('leave.create');
    Route::post('/leave', [LeaveRequestController::class, 'store'])->name('leave.store');
    Route::get('/leave/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('leave.show');
    /* Lines 20-34 omitted */
    Route::patch('/leave/{leaveRequest}/cancel', [LeaveRequestController::class, 'cancel'])->name('leave.cancel');

    // Admin Leave Request Management
    Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/leave-requests', [AdminLeaveRequestController::class, 'index'])->name('leave-requests.index');
        Route::patch('/leave-requests/{leaveRequest}/status', [AdminLeaveRequestController::class, 'updateStatus'])->name('leave-requests.update-status');
    });
});

// Creates employee
Route::get('/employeeCreation', [EmployeeController::class, 'employeeFormPage']);
Route::post('/test', [EmployeeController::class, 'employeeForm']);

// signinPage
Route::get('/signinPage', [EmployeeController::class, 'signinPage']);
Route::post('/employeeProfile', [EmployeeController::class, 'login'])->name('employee.login');
Route::get('/employeeProfile', [EmployeeController::class, 'employeeProfile'])->name('employee.profile');

Route::prefix('admin')->group(function () {
    // Admin auth routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Protected admin routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Admin Payroll Routes
        Route::get('/payroll', [PayrollController::class, 'index'])->name('admin.payroll.index');
        Route::get('/payroll/{employeeID}', [PayrollController::class, 'show'])->name('admin.payroll.show');
        Route::post('/payroll/process', [PayrollController::class, 'process'])->name('admin.payroll.process');
    });
});



// Creates employee
Route::get('/employeeCreation', [EmployeeController::class, 'employeeFormPage' ]);
Route::post('/test', [EmployeeController::class, 'employeeForm' ]);

//signinPage
Route::get('/signinPage', [EmployeeController::class, 'signinPage']);
Route::post('/employeeProfile', [EmployeeController::class, 'login'])->name('employee.login');
Route::get('/employeeProfile', [EmployeeController::class, 'employeeProfile'])->name('employee.profile');

//Edit employee
Route::get('/editEmployee', [EmployeeController::class, 'viewEditEmployee']);
Route::post('/editEmployee', [EmployeeController::class, 'editEmployee']);
