<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function show($id){
        $employee = Employee::findOrFail($id);
        return view('employeeProfile', compact('employee'));
    }
}
