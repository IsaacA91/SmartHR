<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function employeeForm(Request $request){
        $employee = $request->all();

        DB::insert('insert into employee (employeeID, companyID, position, departmentID, firstName, lastName, phone, email, username, password, baseSalary, rate) Values (?,?,?,?,?)',
        []
    );


    }

}
