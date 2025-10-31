<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employeeProfile', function (){
    $employee = Employee::find('E001'); // hardcoded bc no login function atm 
    return view('employeeProfile',['employee'=> $employee]);
});