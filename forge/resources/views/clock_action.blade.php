<?php
use Carbon\Carbon;
use App\Models\AttendanceRecord;

$employee = Auth::guard('employee')->user();
$employeeID = $employee->employeeID;
$action = request('action');
$today = Carbon::today()->toDateString();
$current_time = Carbon::now()->format('H:i:s');
// this grabs the logged in users ID and gets the action clock in or clock out and captures the current date and time

function generateRecordID()
{
    $lastRecord = AttendanceRecord::orderBy('recordID', 'desc')->first();
    
    if ($lastRecord) {
        $lastID = $lastRecord->recordID;
        $number = intval(substr($lastID, 1)) + 1;
        return 'R' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
    
    return 'R00001';
}

if ($action === 'clock_in') {
    // Check if already clocked in
    $existingRecord = AttendanceRecord::where('employeeID', $employeeID)
        ->where('workDay', $today)
        ->whereNull('timeOut')
        ->first();

    if ($existingRecord) {
        return redirect()->route('attendance.dashboard')->with('error', 'You are already clocked in!');
    }

    $recordID = generateRecordID();
    
    // Create new record
    try {
        AttendanceRecord::create([
            'recordID' => $recordID,
            'employeeID' => $employeeID,
            'workDay' => $today,
            'timeIn' => $current_time
        ]);
        
        return redirect()->route('attendance.dashboard')
            ->with('success', 'Successfully clocked in at ' . Carbon::parse($current_time)->format('h:i A'));
    } catch (\Exception $e) {
        return redirect()->route('attendance.dashboard')
            ->with('error', 'Error clocking in: ' . $e->getMessage());
    }
} elseif ($action === 'clock_out') {
    $recordID = request('recordID');
    $record = AttendanceRecord::where('recordID', $recordID)->first();

    if ($record) {
        $time_in = strtotime($today . ' ' . $record['timeIn']);
        $time_out = strtotime($today . ' ' . $current_time);
        $hours_worked = round(($time_out - $time_in) / 3600, 1);  // calcualtes how many hours were worked by convering seconds to hours and rounds to one decimal place

        $update_query = "UPDATE attendancerecord 
                        SET timeOut = '$current_time', hoursWorked = '$hours_worked' 
                        WHERE recordID = '$recordID'";  // updates the recird

        if (mysqli_query($conn, $update_query)) {
            $_SESSION['message'] = 'Successfully clocked out at ' . date('h:i A', strtotime($current_time))  // more feedback from the session
                . '. Total hours worked: ' . $hours_worked;
        } else {
            $_SESSION['message'] = 'Error clocking out: ' . mysqli_error($conn);
        }
    }
}

header('Location: attendance.php');  // after any type of action it redirects back to the attendance page, the messgae stored in $_Session[manager] can also be displayedhere
exit();
?>