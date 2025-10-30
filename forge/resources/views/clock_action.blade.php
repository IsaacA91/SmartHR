<?php
// you got it folks time for how these functions work
require_once 'db_config.php';

if (!isset($_SESSION['employeeID'])) {
    header('Location: login.php');
    exit();
}  // this checks if the user is logged in if not it will redirect to login

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: attendance.php');
    exit();
}  // this makes sure it was submitted via post,so if some naughty person tried cheating into then they get sent to attendance page

$employeeID = $_SESSION['employeeID'];
$action = $_POST['action'];
$today = date('Y-m-d');
$current_time = date('H:i:s');
// this grabs the logged in users ID and gets the action clock in or clock out and captures the current date and time

function generateRecordID($conn)
{
    $query = 'SELECT recordID FROM attendancerecord ORDER BY recordID DESC LIMIT 1';
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastID = $row['recordID'];
        $number = intval(substr($lastID, 1)) + 1;
        return 'R' . str_pad($number, 5, '0', STR_PAD_LEFT);
    } else {
        return 'R00001';
    }
}  // fetches the latest recordID from the table, and makes suer each one is uniqge by padding it with 0's

if ($action === 'clock_in') {  // checks if already clocked in
    $check_query = "SELECT * FROM attendancerecord WHERE employeeID = '$employeeID' AND workDay = '$today' AND timeOut IS NULL";  // makes sure there are no duplicate lock in for the same day
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['message'] = 'You are already clocked in!';
        header('Location: attendance.php');
        exit();
    }

    $recordID = generateRecordID($conn);  // generate new record ID
    // insert new record
    $insert_query = "INSERT INTO attendancerecord (recordID, employeeID, workDay, timeIn) 
                     VALUES ('$recordID', '$employeeID', '$today', '$current_time')";

    if (mysqli_query($conn, $insert_query)) {
        $_SESSION['message'] = 'Successfully clocked in at ' . date('h:i A', strtotime($current_time));  // feedback from the session
    } else {
        $_SESSION['message'] = 'Error clocking in: ' . mysqli_error($conn);
    }
} elseif ($action === 'clock_out') {  // clock out function
    $recordID = $_POST['recordID'];

    $get_query = "SELECT timeIn FROM attendancerecord WHERE recordID = '$recordID'";  // gets timein from the record
    $get_result = mysqli_query($conn, $get_query);
    $record = mysqli_fetch_assoc($get_result);

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