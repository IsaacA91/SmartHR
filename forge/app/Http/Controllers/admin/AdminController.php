<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
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

        // Count pending leave requests
        $pendingLeaveRequests = DB::table('leaverequests as l')
            ->join('employee as e', function ($join) {
                $join->on('l.employeeID', '=', DB::raw('e.employeeID COLLATE utf8mb4_unicode_ci'));
            })
            ->where('e.companyID', $companyID)
            ->where('l.approval', '=', 'Pending')
            ->count();

        return view('admindashboard', compact(
            'totalEmployees',
            'presentToday',
            'absentToday',
            'totalPayroll',
            'recentLeaveRequests',
            'attendanceTrends',
            'departmentDistribution',
            'companyName',
            'pendingLeaveRequests'
        ));
    }

    public function employeeList(Request $request)
    {
        $companyID = Auth::guard('admin')->user()->companyID;
        $search = $request->get('search');
        
        $employees = Employee::with('department')
            ->where('companyID', $companyID)
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('firstName', 'LIKE', "%{$search}%")
                      ->orWhere('lastName', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('employeeID', 'LIKE', "%{$search}%")
                      ->orWhereHas('department', function($deptQuery) use ($search) {
                          $deptQuery->where('departmentName', 'LIKE', "%{$search}%");
                      });
                });
            })
            ->orderBy('lastName');

        // If AJAX request, return JSON for autocomplete
        if ($request->ajax() || $request->get('ajax')) {
            $results = $employees->limit(10)->get()->map(function($employee) {
                return [
                    'employeeID' => $employee->employeeID,
                    'firstName' => $employee->firstName,
                    'lastName' => $employee->lastName,
                    'email' => $employee->email,
                    'department' => $employee->department->departmentName ?? null
                ];
            });
            return response()->json($results);
        }

        // Regular paginated view
        $employees = $employees->paginate(10)->appends(['search' => $search]);

        return view('employeeList', compact('employees'));
    }

    public function showEditForm($id)
    {
        $employee = Employee::with('department')->findOrFail($id);
        $departments = Department::all();

        return view('editEmployee', compact('employee', 'departments'));
    }

    public function updateEmployee(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->only([
            'firstName', 'lastName', 'email', 'phone', 'position', 'departmentID'
        ]));

        return redirect()->route('admin.employeeList')->with('success', 'Employee updated successfully.');
    }

    public function showPresentEmployees(Request $request)
    {
        $today = Carbon::today();
        $companyID = Auth::guard('admin')->user()->companyID;
        $search = $request->input('search');

        $query = AttendanceRecord::whereDate('workDay', $today)
            ->whereNotNull('timeIn')
            ->whereNull('timeOut')
            ->join('employee', 'attendancerecord.employeeID', '=', 'employee.employeeID')
            ->join('department', 'employee.departmentID', '=', 'department.departmentID')
            ->where('employee.companyID', $companyID)
            ->select(
                'attendancerecord.*',
                'employee.firstName',
                'employee.lastName',
                'employee.position',
                'employee.employeeID as empID',
                'department.departmentName'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('employee.firstName', 'LIKE', "%{$search}%")
                  ->orWhere('employee.lastName', 'LIKE', "%{$search}%")
                  ->orWhere('employee.employeeID', 'LIKE', "%{$search}%")
                  ->orWhere('employee.position', 'LIKE', "%{$search}%")
                  ->orWhere('department.departmentName', 'LIKE', "%{$search}%");
            });
        }

        $presentToday = $query->orderBy('employee.employeeID')->paginate(10)->withQueryString();

        return view('presentList', compact('presentToday'));
    }

    public function leaveDirectory(Request $request)
    {
        $companyID = Auth::guard('admin')->user()->companyID;
        $search = $request->get('search');

        // Get all leave requests for the company with employee details
        $query = DB::table('leaverequests as l')
            ->join(DB::raw('(SELECT employeeID, firstName, lastName FROM employee WHERE companyID COLLATE utf8mb4_unicode_ci = ?) as e'),
                function ($join) {
                    $join->on('l.employeeID', '=', DB::raw('e.employeeID COLLATE utf8mb4_unicode_ci'));
                })
            ->select('l.*', 'e.firstName', 'e.lastName')
            ->setBindings([$companyID]);

        // Apply search filter if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where(DB::raw('CONCAT(e.firstName, " ", e.lastName)'), 'LIKE', "%{$search}%")
                  ->orWhere('l.approval', 'LIKE', "%{$search}%")
                  ->orWhere('l.employeeID', 'LIKE', "%{$search}%")
                  ->orWhere('l.leaveRecordID', 'LIKE', "%{$search}%");
            });
        }

        $leaveRequests = $query->orderBy('l.startDate', 'desc')->get();

        return view('adminLeaveDirectory', compact('leaveRequests'));
    }
}
