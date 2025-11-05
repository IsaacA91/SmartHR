<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function employeeFormPage(Request $request){
        return view('employeeCreation');
    }

    public function employeeForm(Request $request){
        $employee = $request->all();

        DB::insert('insert into employee (employeeID, companyID, position, departmentID, firstName, lastName, phone, email, username, password, baseSalary, rate) Values (?,?,?,?,?,?,?,?,?,?,?,?)',
        [
        $request->employeeID,
        $request->companyID,
        $request->position,
        $request->departmentID,
        $request->firstName,
        $request->lastName,
        $request->phone,
        $request->email,
        $request->username,
        $request->password,
        $request->baseSalary,
        $request->rate
        ]);
        return $employee;

    }

    public function signinPage() {
    return view('signinPage');
}

public function login(REQUEST $request){
     $username = $request->input('username');
     $password = $request->input('password');

     $employee = DB::table('employee')
            ->where('username', $username)
            ->where('password', $password) 
            ->first();

       if ($employee) {
            // Store user info in session
            session(['employee' => $employee]);
            return redirect()->route('employee.profile');
        } else {
            return back()->withErrors(['Invalid username or password']);
        }     

} 

public function employeeProfile()
    {
        $employee = session('employee');
        if (!$employee) {
            return redirect()->route('signinPage');
        }

        return view('employeeProfile', ['employee' => $employee]);
    }

    public function viewEditEmployee(){
        return view('editEmployee');
    }
public function editEmployee(Request $request){
    $employee = DB::table('employee')
    ->where('employeeID', $request->employeeID)
    ->update([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'email' => $request->email,
        'position' => $request->position
    ]);
    return redirect('/editEmployee');
}
}
