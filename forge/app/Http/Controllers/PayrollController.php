<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Models\AttendanceRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    private function generatePayrollID()
    {
        $lastRecord = PayrollRecord::orderBy('recordID', 'desc')->first();
        if (!$lastRecord) {
            return 'PR0001';
        }
        $lastNumber = intval(substr($lastRecord->recordID, 2));
        return 'PR' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $employees = Employee::where('companyID', $admin->companyID)->get();
        
        $currentPeriodStart = Carbon::now()->startOfMonth();
        $currentPeriodEnd = Carbon::now()->endOfMonth();
        
        $payrollData = [];
        
        foreach ($employees as $employee) {
            $attendance = AttendanceRecord::where('employeeID', $employee->employeeID)
                ->whereBetween('workDay', [$currentPeriodStart, $currentPeriodEnd])
                ->get();
                
            $regularHours = 0;
            $overtimeHours = 0;
            
            foreach ($attendance as $record) {
                $hours = $record->hoursWorked;
                if ($hours > 8) {
                    $regularHours += 8;
                    $overtimeHours += ($hours - 8);
                } else {
                    $regularHours += $hours;
                }
            }
            
            $payrollData[] = [
                'employee' => $employee,
                'regularHours' => $regularHours,
                'overtimeHours' => $overtimeHours,
                'regularPay' => $regularHours * $employee->rate,
                'overtimePay' => $overtimeHours * ($employee->rate * 1.5),
                'totalPay' => ($regularHours * $employee->rate) + ($overtimeHours * ($employee->rate * 1.5)),
            ];
        }
        
        return view('payroll.index', [
            'payrollData' => $payrollData,
            'periodStart' => $currentPeriodStart,
            'periodEnd' => $currentPeriodEnd
        ]);
    }

    public function show($employeeID)
    {
        $employee = Employee::findOrFail($employeeID);
        $payrollRecords = PayrollRecord::where('employeeID', $employeeID)
            ->orderBy('payPeriodEnd', 'desc')
            ->get();
            
        return view('payroll.show', [
            'employee' => $employee,
            'payrollRecords' => $payrollRecords
        ]);
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'employeeID' => 'required|exists:employee,employeeID',
            'periodStart' => 'required|date',
            'periodEnd' => 'required|date|after:periodStart'
        ]);

        $employee = Employee::findOrFail($request->employeeID);
        
        // Check if payroll already exists for this period
        $existingPayroll = PayrollRecord::where('employeeID', $employee->employeeID)
            ->whereBetween('payPeriodStart', [$request->periodStart, $request->periodEnd])
            ->first();
            
        if ($existingPayroll) {
            return back()->with('error', 'Payroll record already exists for this period');
        }
        
        $attendance = AttendanceRecord::where('employeeID', $employee->employeeID)
            ->whereBetween('workDay', [$request->periodStart, $request->periodEnd])
            ->get();
            
        $regularHours = 0;
        $overtimeHours = 0;
        
        foreach ($attendance as $record) {
            $hours = $record->hoursWorked;
            if ($hours > 8) {
                $regularHours += 8;
                $overtimeHours += ($hours - 8);
            } else {
                $regularHours += $hours;
            }
        }
        
        $payroll = new PayrollRecord([
            'recordID' => $this->generatePayrollID(),
            'employeeID' => $employee->employeeID,
            'payPeriodStart' => $request->periodStart,
            'payPeriodEnd' => $request->periodEnd,
            'regularHours' => $regularHours,
            'overtimeHours' => $overtimeHours,
            'status' => 'processed'
        ]);
        
        $payroll->employee()->associate($employee);
        $payroll->calculatePay();
        $payroll->save();
        
        return redirect()->route('payroll.show', $employee->employeeID)
            ->with('success', 'Payroll processed successfully');
    }
}