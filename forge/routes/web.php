<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Http\Controllers\EmployeeController;


Route::get('/', function () {
    return view('welcome');
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
