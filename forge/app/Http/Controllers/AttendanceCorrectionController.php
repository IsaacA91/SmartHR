<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceCorrectionController extends Controller
{
    public function index()
    {
        $records = AttendanceRecord::with('employee')
            ->orderBy('workDay', 'desc')
            ->orderBy('timeIn', 'desc')
            ->paginate(20);

        return view('attendance.corrections.index', compact('records'));
    }

    public function edit($id)
    {
        $record = AttendanceRecord::findOrFail($id);
        return view('attendance.corrections.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'workDay' => 'required|date',
            'timeIn' => 'required',
            'timeOut' => 'nullable',
        ]);

        $record = AttendanceRecord::findOrFail($id);
        
        // Calculate hours worked
        $hoursWorked = 0;
        if ($request->timeOut) {
            $timeIn = Carbon::parse($request->workDay . ' ' . $request->timeIn);
            $timeOut = Carbon::parse($request->workDay . ' ' . $request->timeOut);
            
            // If timeOut is before timeIn, assume it's next day
            if ($timeOut->lt($timeIn)) {
                $timeOut->addDay();
            }
            
            $hoursWorked = $timeIn->diffInHours($timeOut, true);
            
            // Safety check
            if ($hoursWorked < 0) {
                $hoursWorked = 0;
            }
        }

        $record->update([
            'workDay' => $request->workDay,
            'timeIn' => $request->timeIn,
            'timeOut' => $request->timeOut,
            'hoursWorked' => $hoursWorked,
        ]);

        return redirect()->route('attendance.corrections.index')->with('success', 'Attendance record updated successfully!');
    }

    public function destroy($id)
    {
        $record = AttendanceRecord::findOrFail($id);
        $record->delete();

        return redirect()->route('attendance.corrections.index')->with('success', 'Attendance record deleted successfully!');
    }
}
