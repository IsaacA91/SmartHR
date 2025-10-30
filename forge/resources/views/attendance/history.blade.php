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
        .status-absent {
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
                <a href="{{ route('attendance.dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Back to Attendance
                </a>
            </div>

            <!-- Date Filter -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-5">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->toDateString()) }}">
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
                        <h2>{{ $stats->total_days ?? 0 }}</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <h5>Total Hours</h5>
                        <h2>{{ number_format($stats->total_hours ?? 0, 1) }}</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <h5>Avg Hours/Day</h5>
                        <h2>{{ number_format($stats->avg_hours ?? 0, 1) }}</h2>
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
                                            <span class="status-present">Present</span>
                                        @elseif($record->hoursWorked > 0)
                                            <span class="text-warning">Half Day</span>
                                        @else
                                            <span class="text-muted">In Progress</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No attendance records found for the selected period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                {{ $records->links() }}
                
                <!-- Export Button -->
                <a href="{{ route('attendance.export') }}?start_date={{ request('start_date', now()->startOfMonth()->toDateString()) }}&end_date={{ request('end_date', now()->toDateString()) }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Export to CSV
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>