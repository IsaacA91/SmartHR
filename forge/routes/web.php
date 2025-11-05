<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Http\Controllers\EmployeeController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/eDashboard', function (){
    $employee = Employee::find('E001'); 
    return view('eDashboard', ['employee' => $employee]);
});
Route::get('/employeeProfile/{id}', [EmployeeController::class, 'show'])->name('employeeProfile');
