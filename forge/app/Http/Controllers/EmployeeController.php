<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function employeeFormPage(Request $request)
    {
        return view('employeeCreation');
    }

    public function employeeForm(Request $request)
    {
        $employee = $request->all();
        // Hash the password before storing so Laravel's Auth can verify it using Bcrypt.
        $hashedPassword = Hash::make($request->password);

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
                $hashedPassword,
                $request->baseSalary,
                $request->rate
            ]);
        return $employee;
    }

    public function signinPage()
    {
        return view('signinPage');
    }

    public function login(REQUEST $request)
    {
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
}
