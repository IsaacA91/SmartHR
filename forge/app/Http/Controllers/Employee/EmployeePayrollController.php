<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\PayrollRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeePayrollController extends Controller
{
    public function index()
    {
        $employee = Auth::guard('employee')->user();

        // Get current pay period
        $currentPeriodStart = Carbon::now()->startOfMonth();
        $currentPeriodEnd = Carbon::now()->endOfMonth();

        // Get current period attendance
        $currentPeriodAttendance = AttendanceRecord::where('employeeID', $employee->employeeID)
            ->whereBetween('workDay', [$currentPeriodStart, $currentPeriodEnd])
            ->get();

        // Calculate current period totals
        $regularHours = 0;
        $overtimeHours = 0;
        foreach ($currentPeriodAttendance as $record) {
            $hours = $record->hoursWorked;
            if ($hours > 8) {
                $regularHours += 8;
                $overtimeHours += ($hours - 8);
            } else {
                $regularHours += $hours;
            }
        }

        $currentPeriodTotals = [
            'regularHours' => $regularHours,
            'overtimeHours' => $overtimeHours,
            'regularPay' => $regularHours * $employee->rate,
            'overtimePay' => $overtimeHours * ($employee->rate * 1.5),
            'totalPay' => ($regularHours * $employee->rate) + ($overtimeHours * ($employee->rate * 1.5)),
            'periodStart' => $currentPeriodStart,
            'periodEnd' => $currentPeriodEnd
        ];

        // Get payroll history
        $payrollHistory = PayrollRecord::where('employeeID', $employee->employeeID)
            ->orderBy('payPeriodEnd', 'desc')
            ->get();

        return view('employee.payroll.index', [
            'employee' => $employee,
            'currentPeriod' => $currentPeriodTotals,
            'payrollHistory' => $payrollHistory
        ]);
    }
}
