<?php
require_once 'db_config.php';

if (!isset($_SESSION['employeeID'])) {
    header('Location: login.php');
    exit();
}

$employeeID = $_SESSION['employeeID'];

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

$query = "SELECT * FROM attendancerecord 
          WHERE employeeID = '$employeeID' 
          AND workDay BETWEEN '$start_date' AND '$end_date' 
          ORDER BY workDay DESC, timeIn DESC";
$result = mysqli_query($conn, $query);

$total_query = "SELECT 
                COUNT(*) as total_days,
                SUM(hoursWorked) as total_hours,
                AVG(hoursWorked) as avg_hours
                FROM attendancerecord 
                WHERE employeeID = '$employeeID' 
                AND workDay BETWEEN '$start_date' AND '$end_date'";
$total_result = mysqli_query($conn, $total_query);
$totals = mysqli_fetch_assoc($total_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance History - SmartHR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .history-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 30px;
            margin-top: 30px;
        }
        .summary-card {
            background: linear-gradient(135deg, #5D0703 0%, #FFA18F 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }
        .table-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .status-present {
            color: #28a745;
            font-weight: bold;
        }
        .status-absent { h
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="history-card">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-calendar-week"></i> Attendance History</h2>
                <a href="attendance.php" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Back to Attendance
                </a>
            </div>

            <!-- Date Filter -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-5">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo $start_date; ?>">
                </div>
                <div class="col-md-5">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo $end_date; ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="summary-card">
                        <h5>Total Days</h5>
                        <h2><?php echo $totals['total_days'] ?? 0; ?></h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <h5>Total Hours</h5>
                        <h2><?php echo number_format($totals['total_hours'] ?? 0, 1); ?></h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <h5>Avg Hours/Day</h5>
                        <h2><?php echo number_format($totals['avg_hours'] ?? 0, 1); ?></h2>
                    </div>
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="table-container">
                <h4 class="mb-3">Detailed Records</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <th>Hours Worked</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime($row['workDay'])); ?></td>
                                        <td><?php echo date('l', strtotime($row['workDay'])); ?></td>
                                        <td>
                                            <i class="bi bi-box-arrow-in-right text-success"></i>
                                            <?php echo date('h:i A', strtotime($row['timeIn'])); ?>
                                        </td>
                                        <td>
                                            <?php if ($row['timeOut']): ?>
                                                <i class="bi bi-box-arrow-right text-danger"></i>
                                                <?php echo date('h:i A', strtotime($row['timeOut'])); ?>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Still Clocked In</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row['hoursWorked']): ?>
                                                <span class="badge bg-info"><?php echo $row['hoursWorked']; ?> hrs</span>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row['hoursWorked'] >= 8): ?>
                                                <span class="status-present">Present</span>
                                            <?php elseif ($row['hoursWorked'] > 0): ?>
                                                <span class="text-warning">Half Day</span>
                                            <?php else: ?>
                                                <span class="text-muted">In Progress</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No attendance records found for the selected period.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Export Button -->
            <div class="mt-3 text-end">
                <button class="btn btn-success" onclick="exportToCSV()">
                    <i class="bi bi-download"></i> Export to CSV
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function exportToCSV() {
            window.location.href = 'export_attendance.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>';
        }
    </script>
</body>
</html>