<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AttendanceRecord;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get admin's company ID
        $companyID = Auth::guard('admin')->user()->companyID;

        // Get total employees in the company
        $totalEmployees = Employee::where('companyID', $companyID)->count();

        // Get present and absent employees today
        $today = Carbon::today();
        $presentToday = AttendanceRecord::whereDate('workDay', $today)
            ->whereIn('employeeID', function($query) use ($companyID) {
                $query->select('employeeID')
                      ->from('employee')
                      ->where('companyID', $companyID);
            })
            ->count();
        $absentToday = $totalEmployees - $presentToday;

        // Calculate total payroll this month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalPayroll = AttendanceRecord::whereMonth('workDay', $currentMonth)
            ->whereYear('workDay', $currentYear)
            ->join('employee', 'attendancerecord.employeeID', '=', 'employee.employeeID')
            ->where('employee.companyID', $companyID)
            ->sum(DB::raw('hoursWorked * rate'));

        // Get pending leave requests for the company
        $recentLeaveRequests = LeaveRequest::whereIn('employeeID', function($query) use ($companyID) {
                $query->select('employeeID')
                      ->from('employee')
                      ->where('companyID', $companyID);
            })
            ->where('approval', 'Pending')
            ->orderBy('startDate')
            ->take(5)
            ->get();

        // Get attendance trends for the last 7 days for the company
        $attendanceTrends = AttendanceRecord::select(DB::raw('DATE(workDay) as date'), DB::raw('COUNT(DISTINCT employeeID) as present_count'))
            ->whereIn('employeeID', function($query) use ($companyID) {
                $query->select('employeeID')
                      ->from('employee')
                      ->where('companyID', $companyID);
            })
            ->where('workDay', '>=', Carbon::now()->subDays(7))
            ->groupBy('workDay')
            ->orderBy('workDay')
            ->get();

        // Get department distribution for the company
        $departmentDistribution = Employee::select('department.departmentName', DB::raw('COUNT(*) as count'))
            ->join('department', 'employee.departmentID', '=', 'department.departmentID')
            ->where('employee.companyID', $companyID)
            ->groupBy('department.departmentID', 'department.departmentName')
            ->get();

        return view('admindashboard', compact(
            'totalEmployees',
            'presentToday',
            'absentToday',
            'totalPayroll',
            'recentLeaveRequests',
            'attendanceTrends',
            'departmentDistribution',
            'totalPayroll',
            'recentLeaveRequests',
            'attendanceTrends',
            'departmentDistribution'
        ));
    }
}
