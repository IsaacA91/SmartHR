<?php
use App\Models\AttendanceRecord;
use App\Models\Employee;
use Carbon\Carbon;

$employee = Auth::guard('employee')->user();
$employeeID = $employee->employeeID;
$today = Carbon::today()->toDateString();

$latestRecord = AttendanceRecord::where('employeeID', $employeeID)
    ->where('workDay', $today)
    ->orderBy('recordID', 'desc')
    ->first();

$is_clocked_in = false;
$clock_in_time = null;

if ($latestRecord && $latestRecord->timeOut === null) {
    $is_clocked_in = true;
    $clock_in_time = $latestRecord->timeIn;
}

$month_start = Carbon::now()->startOfMonth()->toDateString();
$month_end = Carbon::now()->endOfMonth()->toDateString();

$stats = AttendanceRecord::where('employeeID', $employeeID)
    ->whereBetween('workDay', [$month_start, $month_end])
    ->selectRaw('COUNT(DISTINCT workDay) as total_days, SUM(hoursWorked) as total_hours, AVG(hoursWorked) as avg_hours')
    ->first();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - SmartHR</title>
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
            min-height: 100vh;
        }

        .attendance-card {
            background: var(--bg-white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }

        .clock-display {
            font-size: 3rem;
            font-weight: bold;
            color: var(--primary-blue);
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

        .btn-success.clock-btn {
            background-color: var(--accent-yellow);
            border-color: var(--accent-yellow);
            color: var(--primary-blue);
        }

        .btn-danger.clock-btn {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .stats-card {
            background: var(--primary-blue);
            color: var(--accent-yellow);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .stats-card h5 {
            font-size: 0.9rem;
            opacity: 0.9;
            color: var(--bg-white);
        }

        .stats-card h3 {
            font-size: 2rem;
            font-weight: bold;
        }

        .btn-outline-secondary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-outline-secondary:hover {
            background-color: var(--primary-blue);
            color: var(--bg-white);
        }

        .btn-outline-primary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-blue);
            color: var(--accent-yellow);
        }

        .btn-outline-warning {
            color: var(--primary-blue);
            border-color: var(--light-blue);
        }

        .alert-success {
            background-color: var(--accent-yellow);
            border-color: var(--accent-yellow);
            color: var(--primary-blue);
        }

        .alert-danger {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .table {
            --bs-table-hover-bg: var(--bg-white);
            --bs-table-hover-color: var(--primary-blue);
        }

        .badge.bg-success {
            background-color: var(--accent-yellow) !important;
            color: var(--primary-blue);
        }

        .badge.bg-warning {
            background-color: var(--light-blue) !important;
            color: var(--primary-blue);
        }

        .badge.bg-info {
            background-color: var(--primary-blue) !important;
            color: var(--accent-yellow);
        }

        .text-warning {
            color: var(--accent-yellow) !important;
        }

        .text-muted {
            color: var(--light-blue) !important;
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
                        <a href="{{ route('attendance.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Employee Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Employee:</strong> {{ $employee->firstName }} {{ $employee->lastName }}</p>
                            <p class="mb-1"><strong>ID:</strong> {{ $employeeID }}</p>
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
                                        <!-- Clock In/Out Button -->
                    <div class="text-center mb-5">
                        <form action="{{ route('attendance.clock') }}" method="POST">
                            @csrf
                            @if ($is_clocked_in)
                                <input type="hidden" name="action" value="clock_out">
                                <input type="hidden" name="recordID" value="{{ $latestRecord->recordID }}">
                                <button type="submit" class="btn btn-danger clock-btn">
                                    <i class="bi bi-box-arrow-right"></i> Clock Out
                                </button>
                            @else
                                <input type="hidden" name="action" value="clock_in">
                                <button type="submit" class="btn btn-success clock-btn">
                                    <i class="bi bi-box-arrow-in-right"></i> Clock In
                                </button>
                            @endif
                        </form>
                    </div>

                    <!-- Today's Sessions -->
                    <h5 class="mb-3">Today's Sessions</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Clock In</th>
                                    <th>Clock Out</th>
                                    <th>Hours</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($todayRecords) && $todayRecords->count())
                                    @foreach($todayRecords as $t)
                                        <tr>
                                            <td>{!! $t->timeIn ? \Carbon\Carbon::parse($t->timeIn)->format('h:i A') : '-' !!}</td>
                                            <td>{!! $t->timeOut ? \Carbon\Carbon::parse($t->timeOut)->format('h:i A') : '<span class="text-warning">Still Clocked In</span>' !!}</td>
                                            <td>{!! $t->hoursWorked ? number_format($t->hoursWorked, 1) . ' hrs' : '-' !!}</td>
                                            <td>
                                                @if($t->timeOut && $t->hoursWorked >= 8)
                                                    <span class="badge bg-success">Present</span>
                                                @elseif($t->timeOut && $t->hoursWorked > 0)
                                                    <span class="badge bg-warning">Partial</span>
                                                @else
                                                    <span class="badge bg-info">In Progress</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No sessions for today.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Monthly Statistics -->

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
                        <a href="{{ route('attendance.history') }}" class="btn btn-outline-primary me-2">
                            <i class="bi bi-calendar-week"></i> View History
                        </a>
                        {{-- Leave request feature to be implemented --}}
                        <a href="#" class="btn btn-outline-warning disabled">
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