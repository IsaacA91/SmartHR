<?php

use App\Http\Controllers\Employee\Auth\LoginController;
use App\Http\Controllers\Employee\AttendanceController;
use App\Http\Controllers\Employee\LeaveRequestController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

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

    // Leave Request Routes
    Route::get('/leave', [LeaveRequestController::class, 'index'])->name('leave.index');
    Route::get('/leave/create', [LeaveRequestController::class, 'create'])->name('leave.create');
    Route::post('/leave', [LeaveRequestController::class, 'store'])->name('leave.store');
    Route::get('/leave/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('leave.show');
    Route::patch('/leave/{leaveRequest}/cancel', [LeaveRequestController::class, 'cancel'])->name('leave.cancel');
});

// Creates employee
Route::get('/employeeCreation', [EmployeeController::class, 'employeeFormPage']);
Route::post('/test', [EmployeeController::class, 'employeeForm']);

// signinPage
Route::get('/signinPage', [EmployeeController::class, 'signinPage']);
Route::post('/employeeProfile', [EmployeeController::class, 'login'])->name('employee.login');
Route::get('/employeeProfile', [EmployeeController::class, 'employeeProfile'])->name('employee.profile');
