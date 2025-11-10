<?php
// Ima add notes on all the main parts for how they work incase yall wanna reference them
require_once 'db_config.php';

if (!isset($_SESSION['employeeID'])) {
    header('Location: login.php');
    exit();
}

$employeeID = $_SESSION['employeeID'];
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

$today = date('Y-m-d');
$check_query = "SELECT * FROM attendancerecord WHERE employeeID = '$employeeID' AND workDay = '$today' ORDER BY recordID DESC LIMIT 1";
$check_result = mysqli_query($conn, $check_query);
$today_record = mysqli_fetch_assoc($check_result);

$is_clocked_in = false;
$clock_in_time = null;

if ($today_record) {
    if ($today_record['timeOut'] === null) {
        $is_clocked_in = true;
        $clock_in_time = $today_record['timeIn'];
    }
}

$emp_query = "SELECT * FROM employee WHERE employeeID = '$employeeID'";
$emp_result = mysqli_query($conn, $emp_query);
$employee = mysqli_fetch_assoc($emp_result);

$month_start = date('Y-m-01');
$month_end = date('Y-m-t');
$stats_query = "SELECT 
                COUNT(DISTINCT workDay) as total_days,
                SUM(hoursWorked) as total_hours,
                AVG(hoursWorked) as avg_hours
                FROM attendancerecord 
                WHERE employeeID = '$employeeID' 
                AND workDay BETWEEN '$month_start' AND '$month_end'";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - SmartHR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #FC703C 0%, #FFA18F 100%);
            min-height: 100vh;
        }
        .attendance-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .clock-display {
            font-size: 3rem;
            font-weight: bold;
            color: #5D0703;
            font-family: 'Courier New', monospace;
        }
        .status-badge {
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 50px;
        }
        .clock-btn {
            padding: 15px 50px;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .clock-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .stats-card {
            background: linear-gradient(135deg, #5D0703 0%, #FC703C 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stats-card h5 {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .stats-card h3 {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="attendance-card">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="bi bi-clock-history"></i> Attendance System</h2>
                        <a href="employeeProfile.blade.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Employee Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Employee:</strong> <?php echo $employee['firstName'] . ' ' . $employee['lastName']; ?></p>
                            <p class="mb-1"><strong>ID:</strong> <?php echo $employeeID; ?></p>
                            <p class="mb-1"><strong>Department:</strong> <?php echo $employee['department']; ?></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-1"><strong>Date:</strong> <?php echo date('F d, Y'); ?></p>
                            <p class="mb-1"><strong>Day:</strong> <?php echo date('l'); ?></p>
                        </div>
                    </div>

                    <!-- Current Time Display -->
                    <div class="text-center mb-4">
                        <div id="currentTime" class="clock-display"></div>
                    </div>

                    <!-- Clock Status -->
                    <div class="text-center mb-4">
                        <?php if ($is_clocked_in): ?>
                            <span class="badge status-badge bg-success">
                                <i class="bi bi-circle-fill"></i> Clocked In since <?php echo date('h:i A', strtotime($clock_in_time)); ?>
                            </span>
                        <?php else: ?>
                            <span class="badge status-badge bg-secondary">
                                <i class="bi bi-circle"></i> Not Clocked In
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Clock In/Out Button -->
                    <div class="text-center mb-5">
                        <form action="clock_action.php" method="POST">
                            <?php if ($is_clocked_in): ?>
                                <input type="hidden" name="action" value="clock_out">
                                <input type="hidden" name="recordID" value="<?php echo $today_record['recordID']; ?>">
                                <button type="submit" class="btn btn-danger clock-btn">
                                    <i class="bi bi-box-arrow-right"></i> Clock Out
                                </button>
                            <?php else: ?>
                                <input type="hidden" name="action" value="clock_in">
                                <button type="submit" class="btn btn-success clock-btn">
                                    <i class="bi bi-box-arrow-in-right"></i> Clock In
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>

                    <!-- Monthly Statistics -->
                    <h4 class="mb-3">This Month's Statistics</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h5>Total Days Worked</h5>
                                <h3><?php echo $stats['total_days'] ?? 0; ?></h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h5>Total Hours</h5>
                                <h3><?php echo number_format($stats['total_hours'] ?? 0, 1); ?></h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h5>Average Hours/Day</h5>
                                <h3><?php echo number_format($stats['avg_hours'] ?? 0, 1); ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="mt-4 text-center">
                        <a href="attendance_history.php" class="btn btn-outline-primary me-2">
                            <i class="bi bi-calendar-week"></i> View History
                        </a>
                        <a href="leave_request.php" class="btn btn-outline-warning">
                            <i class="bi bi-calendar-x"></i> Request Leave
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
     
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            document.getElementById('currentTime').textContent = timeString;
        }
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>