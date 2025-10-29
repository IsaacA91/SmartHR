<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employeeProfile', function (){
    return view('employeeProfile');
});

Route::get('/employeeCreation', [EmployeeController::class, 'employeeFormPage' ]);
Route::post('/test', [EmployeeController::class, 'employeeForm' ]);