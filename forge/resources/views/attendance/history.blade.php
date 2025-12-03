<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance History - SmartHR</title>
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
            animation: float 22s infinite ease-in-out;
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

        .history-card {
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

        .history-card::before {
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

        /* Filter Form */
        .filter-form {
            background: rgba(171, 196, 255, 0.2);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid rgba(72, 73, 232, 0.1);
        }

        .filter-form label {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .filter-form .form-control {
            border: 2px solid rgba(72, 73, 232, 0.2);
            border-radius: 12px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .filter-form .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(72, 73, 232, 0.2);
            transform: translateY(-2px);
        }

        .btn-filter {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            border: none;
            color: white;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(72, 73, 232, 0.3);
        }

        /* Summary Cards */
        .summary-card {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(72, 73, 232, 0.3);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            animation: cardSlideIn 0.6s ease-out backwards;
        }

        .summary-card:nth-child(1) { animation-delay: 0.1s; }
        .summary-card:nth-child(2) { animation-delay: 0.2s; }
        .summary-card:nth-child(3) { animation-delay: 0.3s; }

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

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .summary-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(72, 73, 232, 0.4);
        }

        .summary-card h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 15px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .summary-card h2 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent-yellow), white);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
            margin: 0;
        }

        /* Table Container */
        .table-container {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            animation: fadeIn 0.8s ease-out 0.4s backwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .table-container h4 {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 20px;
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
            animation: rowFadeIn 0.5s ease-out backwards;
        }

        .table tbody tr:nth-child(1) { animation-delay: 0.5s; }
        .table tbody tr:nth-child(2) { animation-delay: 0.55s; }
        .table tbody tr:nth-child(3) { animation-delay: 0.6s; }
        .table tbody tr:nth-child(4) { animation-delay: 0.65s; }
        .table tbody tr:nth-child(5) { animation-delay: 0.7s; }

        @keyframes rowFadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .table tbody tr:hover {
            background: rgba(171, 196, 255, 0.3);
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(72, 73, 232, 0.1);
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
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, var(--accent-yellow), rgba(221, 227, 68, 0.8)) !important;
            color: var(--primary-blue) !important;
        }

        .badge.bg-info {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue)) !important;
            color: white !important;
        }

        .status-present {
            color: #28a745;
            font-weight: 700;
            font-size: 1.05rem;
        }

        .text-warning {
            color: #ff9800 !important;
            font-weight: 600;
        }

        .text-muted {
            color: var(--light-blue) !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        /* Export Button */
        .btn-export {
            background: linear-gradient(135deg, var(--accent-yellow), rgba(221, 227, 68, 0.8));
            border: none;
            color: var(--primary-blue);
            padding: 15px 35px;
            border-radius: 15px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(221, 227, 68, 0.3);
        }

        .btn-export:hover {
            background: linear-gradient(135deg, rgba(221, 227, 68, 0.9), var(--accent-yellow));
            color: var(--primary-blue);
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(221, 227, 68, 0.4);
        }

        /* Pagination */
        .pagination {
            margin: 0;
        }

        .pagination .page-link {
            color: var(--primary-blue);
            border: 2px solid rgba(72, 73, 232, 0.2);
            border-radius: 10px;
            margin: 0 5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
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
        <div class="history-card">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-header"><i class="bi bi-calendar-week"></i> Attendance History</h2>
                <a href="{{ route('attendance.dashboard') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Back to Attendance
                </a>
            </div>

            <!-- Date Filter -->
            <form method="GET" class="row g-3 filter-form">
                <div class="col-md-5">
                    <label class="form-label"><i class="bi bi-calendar-event"></i> Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label"><i class="bi bi-calendar-event"></i> End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->toDateString()) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-filter w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="summary-card">
                        <h5><i class="bi bi-calendar-check"></i> Total Days</h5>
                        <h2>{{ $stats->total_days ?? 0 }}</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <h5><i class="bi bi-clock-history"></i> Total Hours</h5>
                        <h2>{{ number_format($stats->total_hours ?? 0, 1) }}</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <h5><i class="bi bi-graph-up"></i> Avg Hours/Day</h5>
                        <h2>{{ number_format($stats->avg_hours ?? 0, 1) }}</h2>
                    </div>
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="table-container">
                <h4 class="mb-3"><i class="bi bi-list-ul"></i> Detailed Records</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="bi bi-calendar3"></i> Date</th>
                                <th><i class="bi bi-calendar-day"></i> Day</th>
                                <th><i class="bi bi-box-arrow-in-right"></i> Clock In</th>
                                <th><i class="bi bi-box-arrow-right"></i> Clock Out</th>
                                <th><i class="bi bi-clock"></i> Hours Worked</th>
                                <th><i class="bi bi-flag"></i> Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record->workDay)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($record->workDay)->format('l') }}</td>
                                    <td>
                                        <i class="bi bi-box-arrow-in-right text-success"></i>
                                        {{ \Carbon\Carbon::parse($record->timeIn)->format('h:i A') }}
                                    </td>
                                    <td>
                                        @if($record->timeOut)
                                            <i class="bi bi-box-arrow-right text-danger"></i>
                                            {{ \Carbon\Carbon::parse($record->timeOut)->format('h:i A') }}
                                        @else
                                            <span class="badge bg-warning">Still Clocked In</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->hoursWorked)
                                            <span class="badge bg-info">{{ number_format($record->hoursWorked, 1) }} hrs</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->hoursWorked >= 8)
                                            <span class="status-present"><i class="bi bi-check-circle-fill"></i> Present</span>
                                        @elseif($record->hoursWorked > 0)
                                            <span class="text-warning"><i class="bi bi-exclamation-circle-fill"></i> Half Day</span>
                                        @else
                                            <span class="text-muted"><i class="bi bi-clock-fill"></i> In Progress</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No attendance records found for the selected period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination for ... -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                {{ $records->links() }}
                
                <!-- Export Button -->
                <a href="{{ route('attendance.export') }}?start_date={{ request('start_date', now()->startOfMonth()->toDateString()) }}&end_date={{ request('end_date', now()->toDateString()) }}" class="btn btn-export">
                    <i class="bi bi-download"></i> Export to CSV
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>