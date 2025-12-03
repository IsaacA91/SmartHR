<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function employeeFormPage(Request $request)
    {
        // Get the next available employee ID
        $maxId = DB::table('employee')->orderBy('employeeID', 'desc')->value('employeeID');
        $nextId = 'E001';
        
        if ($maxId) {
            // Extract the number from the ID (e.g., E501 -> 501)
            $number = intval(substr($maxId, 1));
            $nextNumber = $number + 1;
            $nextId = 'E' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }
        
        return view('employeeCreation', ['nextEmployeeID' => $nextId]);
    }

    public function employeeForm(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'employeeID' => 'required|max:4|unique:employee,employeeID',
            'companyID' => 'required|max:4',
            'position' => 'required|max:25',
            'departmentID' => 'required|max:4',
            'firstName' => 'required|max:25',
            'lastName' => 'required|max:25',
            'phone' => 'required',
            'email' => 'required|email|max:50|unique:employee,email',
            'username' => 'required|max:29|unique:employee,username',
            'password' => 'required',
            'baseSalary' => 'required|numeric|between:0,999999.99',
            'rate' => 'required|numeric|between:0,999.99'
        ]);

        // Hash the password
        $hashedPassword = Hash::make($request->password);

        // Convert string values to proper decimal format
        $baseSalary = floatval($request->baseSalary);
        $rate = floatval($request->rate);

        // Insert the employee record
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
                $baseSalary,
                $rate
            ]);

        // Get the inserted employee data
        $employee = DB::table('employee')->where('employeeID', $request->employeeID)->first();

        // Return to a success page with the employee data
        return redirect()->route('employee.profile')->with('employee', $employee);
    }

    public function signinPage()
    {
        return view('signinPage');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Get employee by username
        $employee = DB::table('employee')
            ->where('username', $request->username)
            ->first();

        // Check if employee exists and password matches
        if ($employee && Hash::check($request->password, $employee->password)) {
            // Use the employee guard for authentication
            Auth::guard('employee')->loginUsingId($employee->employeeID);
            
            return redirect()->route('employee.dashboard');
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Invalid username or password']);
    }

    public function employeeProfile()
    {
        $employee = Auth::guard('employee')->user();
        
        if (!$employee) {
            return redirect()->route('signinPage');
        }

        return view('employeeProfile', ['employee' => $employee]);
    }

    public function dashboard()
    {
        $employee = Auth::guard('employee')->user();
        
        if (!$employee) {
            return redirect()->route('signinPage');
        }

        return view('eDashboard', ['employee' => $employee]);
    }
}
