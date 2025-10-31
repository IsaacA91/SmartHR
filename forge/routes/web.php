<?php

use App\Http\Controllers\Employee\Auth\LoginController;
use App\Http\Controllers\Employee\AttendanceController;
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
});

Route::get('/employeeProfile', function (){
    return view('employeeProfile');
});