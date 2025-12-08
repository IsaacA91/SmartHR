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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #4849E8;
            --light-blue: #ABC4FF;
            --accent-yellow: #DDF344;
            --bg-white: #F5F9FF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--bg-white) 0%, var(--light-blue) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background Shapes */
        .shape {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            z-index: 0;
            animation: float 20s infinite ease-in-out;
        }

        .shape1 {
            width: 450px;
            height: 450px;
            background: var(--primary-blue);
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .shape2 {
            width: 350px;
            height: 350px;
            background: var(--accent-yellow);
            bottom: -100px;
            right: -100px;
            animation-delay: 7s;
        }

        .shape3 {
            width: 400px;
            height: 400px;
            background: var(--light-blue);
            top: 50%;
            right: -150px;
            animation-delay: 14s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -30px) rotate(90deg); }
            50% { transform: translate(-20px, 20px) rotate(180deg); }
            75% { transform: translate(40px, 10px) rotate(270deg); }
        }

        /* Particles */
        .particle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: var(--primary-blue);
            border-radius: 50%;
            opacity: 0.3;
            z-index: 0;
            animation: floatParticle 15s infinite ease-in-out;
        }

        @keyframes floatParticle {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-100px) translateX(50px); }
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .attendance-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(72, 73, 232, 0.2);
            padding: 40px;
            margin-top: 50px;
            margin-bottom: 50px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .attendance-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(221, 227, 68, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-header i {
            background: var(--primary-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2rem;
        }

        .btn-back {
            background: rgba(72, 73, 232, 0.1);
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 10px 25px;
            border-radius: 15px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-back:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(72, 73, 232, 0.3);
        }

        /* Alert Styling */
        .alert {
            border-radius: 15px;
            border: none;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
            font-weight: 600;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            font-weight: 600;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Employee Info Section */
        .info-section {
            background: rgba(171, 196, 255, 0.2);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid rgba(72, 73, 232, 0.1);
        }

        .info-section p {
            margin-bottom: 8px;
            color: var(--primary-blue);
            font-size: 1rem;
        }

        .info-section strong {
            color: var(--primary-blue);
            font-weight: 700;
        }

        /* Clock Display */
        .clock-container {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            border-radius: 25px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 15px 40px rgba(72, 73, 232, 0.3);
            position: relative;
            overflow: hidden;
        }

        .clock-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .clock-display {
            font-size: 4rem;
            font-weight: 700;
            color: white;
            font-family: 'Courier New', monospace;
            text-shadow: 0 5px 20px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
            letter-spacing: 5px;
        }

        /* Status Badge */
        .status-badge {
            font-size: 1.1rem;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            animation: pulse 2s infinite ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }

        .status-badge.bg-success {
            background: rgba(34, 197, 94, 0.15) !important;
            color: #16a34a !important;
            border: 2px solid rgba(34, 197, 94, 0.3);
        }

        .status-badge.bg-secondary {
            background: rgba(100, 116, 139, 0.15) !important;
            color: #475569 !important;
            border: 2px solid rgba(100, 116, 139, 0.3);
        }

        /* Clock Button */
        .clock-btn {
            padding: 20px 60px;
            font-size: 1.3rem;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .clock-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .clock-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .clock-btn:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .clock-btn:active {
            transform: translateY(-4px);
        }

        .btn-success.clock-btn {
            background: linear-gradient(135deg, var(--accent-yellow), rgba(221, 227, 68, 0.8));
            color: var(--primary-blue);
        }

        .btn-danger.clock-btn {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
        }

        /* Table Styling */
        .table-container {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .table {
            margin-bottom: 0;
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
        }

        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(171, 196, 255, 0.2);
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(72, 73, 232, 0.1);
        }

        .table .badge {
            padding: 8px 15px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 8px;
        }

        .table .badge.bg-success {
            background: rgba(34, 197, 94, 0.15) !important;
            color: #16a34a !important;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .badge.bg-warning {
            background: rgba(221, 243, 68, 0.2) !important;
            color: #65a30d !important;
            border: 1px solid rgba(221, 243, 68, 0.5);
        }

        .badge.bg-info {
            background: rgba(72, 73, 232, 0.1) !important;
            color: var(--primary-blue) !important;
            border: 1px solid rgba(72, 73, 232, 0.3);
        }

        /* Stats Cards */
        .stats-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            color: var(--primary-blue);
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 40px rgba(72, 73, 232, 0.12);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            animation: cardSlideIn 0.6s ease-out backwards;
            border: 2px solid rgba(72, 73, 232, 0.1);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-blue), var(--light-blue));
        }

        .stats-card::after {
            content: '';
            position: absolute;
            top: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(72, 73, 232, 0.1), rgba(171, 196, 255, 0.2));
            border-radius: 16px;
            z-index: 0;
        }

        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }

        .stats-card:nth-child(1)::before {
            background: linear-gradient(90deg, var(--primary-blue), var(--light-blue));
        }

        .stats-card:nth-child(2)::before {
            background: linear-gradient(90deg, var(--accent-yellow), #a3e635);
        }

        .stats-card:nth-child(3)::before {
            background: linear-gradient(90deg, var(--light-blue), var(--primary-blue));
        }

        @keyframes cardSlideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .stats-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 50px rgba(72, 73, 232, 0.2);
            border-color: rgba(72, 73, 232, 0.3);
        }

        .stats-card h5 {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
        }

        .stats-card h3 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--primary-blue);
            position: relative;
            z-index: 1;
            margin: 0;
        }

        .stats-card .stats-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            color: var(--primary-blue);
            opacity: 0.3;
            z-index: 1;
        }

        /* Quick Links Section */
        .quick-links {
            margin-top: 40px;
            text-align: center;
        }

        .btn-link-custom {
            background: rgba(72, 73, 232, 0.1);
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 15px 35px;
            border-radius: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0 10px;
            display: inline-block;
        }

        .btn-link-custom:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(72, 73, 232, 0.3);
        }

        .btn-link-custom.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-link-custom.disabled:hover {
            background: rgba(72, 73, 232, 0.1);
            color: var(--primary-blue);
            transform: none;
            box-shadow: none;
        }

        .text-warning {
            color: var(--accent-yellow) !important;
        }

        .text-muted {
            color: var(--light-blue) !important;
        }

        h4, h5 {
            color: var(--primary-blue);
            font-weight: 700;
        }
    </style>
</head>
<body>
    <!-- Animated Background Shapes -->
    <div class="shape shape1"></div>
    <div class="shape shape2"></div>
    <div class="shape shape3"></div>
    <!-- Particles -->
    <script>
        for (let i = 0; i < 15; i++) {
            let particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (15 + Math.random() * 10) + 's';
            document.body.appendChild(particle);
        }
    </script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="attendance-card">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="page-header"><i class="bi bi-clock-history"></i> Attendance System</h2>
                        <a href="{{ route('employee.dashboard') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Employee Info -->
                    <div class="row info-section">
                        <div class="col-md-6">
                            <p class="mb-2"><strong><i class="bi bi-person-badge"></i> Employee:</strong> {{ $employee->firstName }} {{ $employee->lastName }}</p>
                            <p class="mb-2"><strong><i class="bi bi-hash"></i> ID:</strong> {{ $employeeID }}</p>
                            <p class="mb-0"><strong><i class="bi bi-building"></i> Department:</strong> {{ $employee->department->departmentName ?? $employee->departmentID }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-2"><strong><i class="bi bi-calendar-check"></i> Date:</strong> <?php echo date('F d, Y'); ?></p>
                            <p class="mb-0"><strong><i class="bi bi-calendar-day"></i> Day:</strong> <?php echo date('l'); ?></p>
                        </div>
                    </div>

                    <!-- Current Time Display -->
                    <div class="text-center mb-4">
                        <div class="clock-container">
                            <div id="currentTime" class="clock-display"></div>
                        </div>
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
                    <h5 class="mb-3"><i class="bi bi-list-check"></i> Today's Sessions</h5>
                    <div class="table-container mb-4">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-box-arrow-in-right"></i> Clock In</th>
                                        <th><i class="bi bi-box-arrow-right"></i> Clock Out</th>
                                        <th><i class="bi bi-clock"></i> Hours</th>
                                        <th><i class="bi bi-flag"></i> Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($todayRecords) && $todayRecords->count())
                                        @foreach($todayRecords as $t)
                                            <tr>
                                                <td>{!! $t->timeIn ? date('g:i A', strtotime($t->timeIn)) : '-' !!}</td>
                                                <td>{!! $t->timeOut ? date('g:i A', strtotime($t->timeOut)) : '<span class="text-warning">Still Clocked In</span>' !!}</td>
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
                    </div>

                    <!-- Monthly Statistics -->
                    <h4 class="mb-3"><i class="bi bi-bar-chart-fill"></i> This Month's Statistics</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h5><i class="bi bi-calendar-check"></i> Total Days Worked</h5>
                                <h3><?php echo $stats['total_days'] ?? 0; ?></h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h5><i class="bi bi-clock-history"></i> Total Hours</h5>
                                <h3><?php echo number_format($stats['total_hours'] ?? 0, 1); ?></h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h5><i class="bi bi-graph-up"></i> Average Hours/Day</h5>
                                <h3><?php echo number_format($stats['avg_hours'] ?? 0, 1); ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="quick-links">
                        <a href="{{ route('attendance.history') }}" class="btn-link-custom">
                            <i class="bi bi-calendar-week"></i> View History
                        </a>
                        <a href="{{ route('leave.create') }}" class="btn-link-custom">
                            <i class="bi bi-calendar-x"></i> Request Leave
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Real-time clock
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