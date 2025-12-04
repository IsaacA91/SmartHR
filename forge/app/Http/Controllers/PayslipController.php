<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\AttendanceRecord;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayslipController extends Controller
{
    public function generatePDF($employeeID, $month, $year)
    {
        $employee = Employee::findOrFail($employeeID);
        
        // Calculate payroll for the month
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        
        $attendance = AttendanceRecord::where('employeeID', $employeeID)
            ->whereBetween('workDay', [$startDate, $endDate])
            ->get();
        
        $totalHours = $attendance->sum('hoursWorked');
        $regularHours = min($totalHours, 160); // 40 hours/week * 4 weeks
        $overtimeHours = max(0, $totalHours - 160);
        
        $regularPay = $employee->baseSalary;
        $overtimePay = $overtimeHours * $employee->rate * 1.5; // 1.5x for overtime
        $grossPay = $regularPay + $overtimePay;
        
        // Simple deductions (can be customized)
        $sss = $grossPay * 0.045; // 4.5% SSS
        $philHealth = $grossPay * 0.02; // 2% PhilHealth
        $pagibig = 200; // Fixed ₱200
        $tax = $grossPay * 0.15; // Simple 15% tax
        
        $totalDeductions = $sss + $philHealth + $pagibig + $tax;
        $netPay = $grossPay - $totalDeductions;
        
        // Generate HTML for PDF
        $html = view('payslip.pdf', compact(
            'employee',
            'startDate',
            'endDate',
            'regularHours',
            'overtimeHours',
            'regularPay',
            'overtimePay',
            'grossPay',
            'sss',
            'philHealth',
            'pagibig',
            'tax',
            'totalDeductions',
            'netPay',
            'attendance'
        ))->render();
        
        // Generate PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream("Payslip_{$employee->firstName}_{$employee->lastName}_{$month}_{$year}.pdf");
    }
}
