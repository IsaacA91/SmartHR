<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PaySlip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeePayrollController extends Controller
{
    /**
     * Display a listing of the payroll records for the logged-in employee.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $employee = Auth::guard('employee')->user();
        $payslips = PaySlip::where('employeeID', $employee->employeeID)
                          ->orderBy('payPeriodBeginning', 'desc')
                          ->paginate(10);

        return view('employee.payroll.index', compact('payslips'));
    }

    /**
     * Display the specified payroll record.
     *
     * @param  \App\Models\PaySlip  $payslip
     * @return \Illuminate\View\View
     */
    public function show(PaySlip $payslip)
    {
        $employee = Auth::guard('employee')->user();

        // Ensure the payslip belongs to the logged-in employee
        if ($payslip->employeeID !== $employee->employeeID) {
            abort(403, 'Unauthorized action.');
        }

        return view('employee.payroll.show', compact('payslip', 'employee'));
    }
}
