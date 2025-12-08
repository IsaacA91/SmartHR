<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WorkSchedule;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkScheduleController extends Controller
{
    private function generateScheduleID()
    {
        $result = DB::select("
            SELECT MAX(CAST(SUBSTRING(scheduleID, 2) AS UNSIGNED)) as max_id 
            FROM workschedule 
            WHERE scheduleID REGEXP '^S[0-9]+$'
        ");

        $maxId = $result[0]->max_id;
        $newNumber = $maxId ? $maxId + 1 : 1;
        $newId = 'S' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        while (WorkSchedule::where('scheduleID', $newId)->exists()) {
            $newNumber++;
            $newId = 'S' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        return $newId;
    }

    public function index()
    {
        $schedules = WorkSchedule::with('employee')
            ->orderBy('shiftDate', 'desc')
            ->paginate(20);

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $employees = Employee::orderBy('firstName')->get();
        return view('schedules.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeID' => 'required|exists:employee,employeeID',
            'shiftDate' => 'required|date',
            'shiftBegin' => 'required',
            'shiftEnd' => 'required',
        ]);

        WorkSchedule::create([
            'scheduleID' => $this->generateScheduleID(),
            'employeeID' => $request->employeeID,
            'shiftDate' => $request->shiftDate,
            'shiftBegin' => $request->shiftBegin,
            'shiftEnd' => $request->shiftEnd,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully!');
    }

    public function edit($id)
    {
        $schedule = WorkSchedule::findOrFail($id);
        $employees = Employee::orderBy('firstName')->get();
        return view('schedules.edit', compact('schedule', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employeeID' => 'required|exists:employee,employeeID',
            'shiftDate' => 'required|date',
            'shiftBegin' => 'required',
            'shiftEnd' => 'required',
        ]);

        $schedule = WorkSchedule::findOrFail($id);
        $schedule->update([
            'employeeID' => $request->employeeID,
            'shiftDate' => $request->shiftDate,
            'shiftBegin' => $request->shiftBegin,
            'shiftEnd' => $request->shiftEnd,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully!');
    }

    public function destroy($id)
    {
        $schedule = WorkSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully!');
    }

    public function bulkCreate()
    {
        $employees = Employee::orderBy('firstName')->get();
        return view('schedules.bulk-create', compact('employees'));
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'employeeID' => 'required|exists:employee,employeeID',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'shiftBegin' => 'required',
            'shiftEnd' => 'required',
            'days_of_week' => 'required|array|min:1',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $daysOfWeek = $request->days_of_week;

        $created = 0;
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            if (in_array($currentDate->dayOfWeek, $daysOfWeek)) {
                WorkSchedule::create([
                    'scheduleID' => $this->generateScheduleID(),
                    'employeeID' => $request->employeeID,
                    'shiftDate' => $currentDate->toDateString(),
                    'shiftBegin' => $request->shiftBegin,
                    'shiftEnd' => $request->shiftEnd,
                ]);
                $created++;
            }
            $currentDate->addDay();
        }

        return redirect()->route('schedules.index')->with('success', "Created $created schedule(s) successfully!");
    }
}
