<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function showDashboard()
    {
        $employeeID = Auth::guard('employee')->user()->employeeID;
        $today = Carbon::today()->toDateString();

        $latestRecord = AttendanceRecord::where('employeeID', $employeeID)
            ->where('workDay', $today)
            ->orderBy('recordID', 'desc')
            ->first();

        return view('attendance.dashboard', compact('latestRecord'));
    }

    public function clockAction(Request $request)
    {
        $employeeID = Auth::guard('employee')->user()->employeeID;
        $today = Carbon::today()->toDateString();

        $record = AttendanceRecord::where('employeeID', $employeeID)
            ->where('workDay', $today)
            ->first();

        if ($request->input('action') === 'clock_in' && !$record) {
            AttendanceRecord::create([
                'recordID' => \Str::random(6),
                'employeeID' => $employeeID,
                'workDay' => $today,
                'timeIn' => Carbon::now()->toTimeString(),
            ]);

            return redirect()->back()->with('success', 'Clocked in successfully!');
        } elseif ($request->input('action') === 'clock_out' && $record && !$record->timeOut) {
            $arrivalTime = Carbon::parse($record->timeIn);
            $departureTime = Carbon::now();
            $totalHours = $departureTime->diffInMinutes($arrivalTime) / 60;

            $record->update([
                'timeOut' => $departureTime->toTimeString(),
                'hoursWorked' => round($totalHours, 1),
            ]);

            return redirect()->back()->with('success', 'Clocked out successfully!');
        }

        return redirect()->back()->with('error', 'Invalid clock action.');
    }
}
