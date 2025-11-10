<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get admin's company ID
        $companyID = Auth::guard('admin')->user()->companyID;
        $companyName = Auth::guard('admin')->user()->company->companyName;
        // Get total employees in the company using explicit collation
        $totalEmployees = Employee::whereRaw('companyID COLLATE utf8mb4_unicode_ci = ?', [$companyID])->count();
        
        // Get present and absent employees today
        $today = Carbon::today();
        $presentToday = AttendanceRecord::whereDate('workDay', $today)
            ->whereIn('employeeID', function ($query) use ($companyID) {
                $query
                    ->select('employeeID')
                    ->distinct()
                    ->from('employee')
                    ->where('companyID', $companyID);
            })
            ->whereNotNull('timeIn')
            ->whereNull('timeOut')
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

        // Get pending leave requests for the company with explicit collation
        $recentLeaveRequests = DB::table('leaverequests as l')
            ->join(DB::raw('(SELECT employeeID, firstName, lastName FROM employee WHERE companyID COLLATE utf8mb4_unicode_ci = ?) as e'),
                function ($join) {
                    $join->on('l.employeeID', '=', DB::raw('e.employeeID COLLATE utf8mb4_unicode_ci'));
                })
            ->where('l.approval', '=', 'Pending')
            ->orderBy('l.startDate', 'asc')
            ->select('l.*', 'e.firstName', 'e.lastName')
            ->setBindings([$companyID, 'Pending'])
            ->limit(5)
            ->get();
        // Get attendance trends for the last 7 days for the company
        $attendanceTrends = AttendanceRecord::select(DB::raw('DATE(workDay) as date'), DB::raw('COUNT(DISTINCT employeeID) as present_count'))
            ->whereIn('employeeID', function ($query) use ($companyID) {
                $query
                    ->select('employeeID')
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
            'companyName'
        ));
    }
    public function showEmployees()
    {
        $companyID = Auth::guard('admin')->user()->companyID;
        $employees = Employee::with('department')
            ->where('companyID', $companyID)
            ->orderBy('lastName')
            ->paginate(10);

        return view('employeeList', compact('employees'));
    }
    public function showEditForm($id)
    {
        $employee = Employee::with('department')->findOrFail($id);
        $departments = Department::all();
        
        return view('editEmployee',compact('employee','departments'));
    }
    public function updateEmployee(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->only([
            'firstName', 'lastName', 'email', 'phone', 'position', 'departmentID'
        ]));

        return redirect()->route('admin.employeeList')->with('success', 'Employee updated successfully.');
    }
}
