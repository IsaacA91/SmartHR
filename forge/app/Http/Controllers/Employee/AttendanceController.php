<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    private function generateRecordID()
    {
        $lastRecord = AttendanceRecord::orderBy('recordID', 'desc')->first();

        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->recordID, 1));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'R' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    public function showHistory(Request $request)
    {
        $employeeID = Auth::guard('employee')->user()->employeeID;
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->toDateString());

        $records = AttendanceRecord::where('employeeID', $employeeID)
            ->whereBetween('workDay', [$startDate, $endDate])
            ->orderBy('workDay', 'desc')
            ->orderBy('timeIn', 'desc')
            ->paginate(15);

        $stats = AttendanceRecord::where('employeeID', $employeeID)
            ->whereBetween('workDay', [$startDate, $endDate])
            ->selectRaw('COUNT(DISTINCT workDay) as total_days, SUM(hoursWorked) as total_hours, AVG(hoursWorked) as avg_hours')
            ->first();

        return view('attendance.history', compact('records', 'stats'));
    }

    public function showDashboard()
    {
        $employee = Auth::guard('employee')->user();
        $employeeID = $employee->employeeID;
        $today = Carbon::today()->toDateString();

        // Get today's record for clock in/out status
        $latestRecord = AttendanceRecord::where('employeeID', $employeeID)
            ->where('workDay', $today)
            ->orderBy('recordID', 'desc')
            ->first();

        // Get monthly stats
        $month_start = Carbon::now()->startOfMonth()->toDateString();
        $month_end = Carbon::now()->endOfMonth()->toDateString();

        $stats = AttendanceRecord::where('employeeID', $employeeID)
            ->whereBetween('workDay', [$month_start, $month_end])
            ->selectRaw('COUNT(DISTINCT workDay) as total_days, SUM(hoursWorked) as total_hours, AVG(hoursWorked) as avg_hours')
            ->first();

        return view('attendance.dashboard', compact('latestRecord', 'employee', 'employeeID', 'stats'));
    }

    public function clockAction(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        if (!$employee) {
            return redirect()->route('employee.login')->with('error', 'Please login first.');
        }

        $employeeID = $employee->employeeID;
        $today = Carbon::today()->toDateString();

        $record = AttendanceRecord::where('employeeID', $employeeID)
            ->where('workDay', $today)
            ->first();

        if ($request->input('action') === 'clock_in' && !$record) {
            try {
                AttendanceRecord::create([
                    'recordID' => $this->generateRecordID(),
                    'employeeID' => $employeeID,
                    'workDay' => $today,
                    'timeIn' => Carbon::now()->toTimeString(),
                ]);

                return redirect()->back()->with('success', 'Clocked in successfully!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error clocking in: ' . $e->getMessage());
            }
        }

        if ($request->input('action') === 'clock_out' && $record && !$record->timeOut) {
            try {
                $arrivalTime = Carbon::parse($record->timeIn);
                $departureTime = Carbon::now();
                $totalHours = $departureTime->diffInMinutes($arrivalTime) / 60;

                $record->update([
                    'timeOut' => $departureTime->toTimeString(),
                    'hoursWorked' => round($totalHours, 1),
                ]);

                return redirect()->back()->with('success', 'Clocked out successfully!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error clocking out: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Invalid clock action.');
    }

    public function exportAttendance(Request $request)
    {
        $employeeID = Auth::guard('employee')->user()->employeeID;
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->toDateString());

        $records = AttendanceRecord::where('employeeID', $employeeID)
            ->whereBetween('workDay', [$startDate, $endDate])
            ->orderBy('workDay', 'desc')
            ->orderBy('timeIn', 'desc')
            ->get();

        $headers = array(
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=attendance_history.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        );

        $columns = array('Date', 'Day', 'Clock In', 'Clock Out', 'Hours Worked', 'Status');

        $callback = function () use ($records, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($records as $record) {
                $workDay = Carbon::parse($record->workDay);
                $row = array(
                    $workDay->format('M d, Y'),
                    $workDay->format('l'),
                    Carbon::parse($record->timeIn)->format('h:i A'),
                    $record->timeOut ? Carbon::parse($record->timeOut)->format('h:i A') : 'Still Clocked In',
                    $record->hoursWorked ? number_format($record->hoursWorked, 1) . ' hrs' : '-',
                    $record->hoursWorked >= 8 ? 'Present' : ($record->hoursWorked > 0 ? 'Half Day' : 'In Progress')
                );
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
