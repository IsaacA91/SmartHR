
<?php
require_once 'db_config.php';

if (!isset($_SESSION['adminID'])) {
    header('Location: admin_login.php');
    exit();
}

$department = isset($_GET['department']) ? $_GET['department'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$query = "SELECT a.*, e.firstName, e.lastName, e.department, e.position 
          FROM attendancerecord a 
          JOIN employee e ON a.employeeID = e.employeeID 
          WHERE a.workDay = '$date'";

if ($department) {
    $query .= " AND e.department = '$department'";
}

$query .= ' ORDER BY a.timeIn DESC';
$result = mysqli_query($conn, $query);

$dept_query = 'SELECT DISTINCT department FROM employee ORDER BY department';
$dept_result = mysqli_query($conn, $dept_query);

$stats_query = "SELECT 
                (SELECT COUNT(DISTINCT employeeID) FROM attendancerecord WHERE workDay = '$date') as present,
                (SELECT COUNT(*) FROM employee) as total_employees";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);
$absent = $stats['total_employees'] - $stats['present'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Attendance Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #4849E8;
            --light-blue: #ABC4FF;
            --accent-yellow: #DDF344;
            --bg-white: #F5F9FF;
        }

        body {
            background: var(--primary-blue);
        }

        .admin-card {
            background: var(--bg-white);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 30px;
            margin-top: 30px;
        }

        .stat-card {
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: var(--bg-white);
        }

        .stat-present {
            background: var(--primary-blue);
        }

        .stat-absent {
            background: var(--light-blue);
            color: var(--primary-blue);
        }

        .stat-total {
            background: var(--accent-yellow);
            color: var(--primary-blue);
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            color: var(--bg-white);
        }

        .btn-primary:hover {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--light-blue);
            box-shadow: 0 0 0 0.25rem rgba(72, 73, 232, 0.25);
        }

        .table-dark {
            background-color: var(--primary-blue);
        }

        .badge.bg-success {
            background-color: var(--accent-yellow) !important;
            color: var(--primary-blue);
        }

        .badge.bg-warning {
            background-color: var(--light-blue) !important;
            color: var(--primary-blue);
        }

        .badge.bg-danger {
            background-color: var(--light-blue) !important;
            color: var(--primary-blue);
        }

        .badge.bg-info {
            background-color: var(--primary-blue) !important;
            color: var(--accent-yellow);
        }

        .text-success {
            color: var(--accent-yellow) !important;
        }

        .text-danger {
            color: var(--light-blue) !important;
        }

        h2 {
            color: var(--primary-blue);
        }

        .form-label {
            color: var(--primary-blue);
        }

        .table {
            --bs-table-hover-bg: var(--bg-white);
            --bs-table-hover-color: var(--primary-blue);
        }

        .text-center {
            color: var(--primary-blue);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="admin-card">
            <h2 class="mb-4"><i class="bi bi-people"></i> Attendance Management - Admin View</h2>

            <!-- Statistics -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stat-card stat-present">
                        <h3><?php echo $stats['present']; ?></h3>
                        <p>Present Today</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card stat-absent">
                        <h3><?php echo $absent; ?></h3>
                        <p>Absent Today</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card stat-total">
                        <h3><?php echo $stats['total_employees']; ?></h3>
                        <p>Total Employees</p>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="<?php echo $date; ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-select">
                        <option value="">All Departments</option>
                        <?php while ($dept = mysqli_fetch_assoc($dept_result)): ?>
                            <option value="<?php echo $dept['department']; ?>" 
                                    <?php echo $department == $dept['department'] ? 'selected' : ''; ?>>
                                <?php echo $dept['department']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>
            </form>

            <!-- Attendance Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Position</th>
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
                                    <td><?php echo $row['employeeID']; ?></td>
                                    <td><?php echo $row['firstName'] . ' ' . $row['lastName']; ?></td>
                                    <td><?php echo $row['department']; ?></td>
                                    <td><?php echo $row['position']; ?></td>
                                    <td>
                                        <i class="bi bi-clock text-success"></i>
                                        <?php echo date('h:i A', strtotime($row['timeIn'])); ?>
                                    </td>
                                    <td>
                                        <?php if ($row['timeOut']): ?>
                                            <i class="bi bi-clock-fill text-danger"></i>
                                            <?php echo date('h:i A', strtotime($row['timeOut'])); ?>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Working</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($row['hoursWorked']): ?>
                                            <?php echo $row['hoursWorked']; ?> hrs
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($row['hoursWorked'] >= 8): ?>
                                            <span class="badge bg-success">Full Day</span>
                                        <?php elseif ($row['hoursWorked'] >= 4): ?>
                                            <span class="badge bg-warning">Half Day</span>
                                        <?php elseif ($row['timeOut']): ?>
                                            <span class="badge bg-danger">Incomplete</span>
                                        <?php else: ?>
                                            <span class="badge bg-info">Active</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No attendance records found for <?php echo date('F d, Y', strtotime($date)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>