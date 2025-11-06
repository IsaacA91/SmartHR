@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --primary-blue: #4849E8;
            --light-blue: #ABC4FF;
            --neon-yellow: #DDF344;
            --white: #F5F9FF;
            --card-shadow: 0 8px 16px rgba(72, 73, 232, 0.1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--white);
            color: var(--primary-blue);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 2rem;
            color: var(--primary-blue);
            letter-spacing: -0.5px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(72, 73, 232, 0.1);
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card h3 {
            color: var(--primary-blue);
            margin: 0 0 10px 0;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--neon-yellow);
            text-shadow: 1px 1px 0 var(--primary-blue);
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-container {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(72, 73, 232, 0.1);
        }

        .chart-container h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-blue);
            letter-spacing: -0.5px;
        }

        .leave-requests {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(72, 73, 232, 0.1);
        }

        .leave-requests h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-blue);
            letter-spacing: -0.5px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1rem;
        }

        th {
            background-color: var(--light-blue);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--primary-blue);
            border-radius: 8px 8px 0 0;
        }

        td {
            padding: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .no-requests {
            color: #6b7280;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 1rem;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 style='border-bottom:5px solid var(--primary-blue)'>{{$companyName}}</h1>
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stats-card">
                <h3>Total Employees</h3>
                <div class="stats-number">{{ $totalEmployees }}</div>
            </div>
            <div class="stats-card">
                <h3>Present Today</h3>
                <div class="stats-number">{{ $presentToday }}</div>
            </div>
            <div class="stats-card">
                <h3>Absent Today</h3>
                <div class="stats-number">{{ $absentToday }}</div>
            </div>
            <div class="stats-card">
                <h3>Total Payroll This Month</h3>
                <div class="stats-number">${{ number_format($totalPayroll, 2) }}</div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <div class="chart-container">
                <h3>Attendance Trends</h3>
                <canvas id="attendanceChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Department Distribution</h3>
                <canvas id="departmentChart"></canvas>
            </div>
        </div>

        <!-- Leave Requests -->
        <div class="leave-requests">
            <h3>Recent Leave Requests</h3>
            @if(count($recentLeaveRequests) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentLeaveRequests as $request)
                        <tr>
                            <td>{{ $request->firstName }} {{ $request->lastName }}</td>
                            <td>Leave</td>
                            <td>{{ \Carbon\Carbon::parse($request->startDate)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($request->endDate)->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('admin.leave-requests.update-status', $request->leaveRecordID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="approval" onchange="this.form.submit()" class="form-select">
                                        <option value="Pending" {{ $request->approval == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Approved" {{ $request->approval == 'Approved' ? 'selected' : '' }}>Approve</option>
                                        <option value="Rejected" {{ $request->approval == 'Rejected' ? 'selected' : '' }}>Reject</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="no-requests">No recent leave requests</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attendance Trends Chart
        const attendanceData = @json($attendanceTrends);
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attendanceCtx, {
            type: 'line',
            data: {
                labels: attendanceData.map(item => item.date),
                datasets: [{
                    label: 'Present Employees',
                    data: attendanceData.map(item => item.present_count),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Department Distribution Chart
        const departmentData = @json($departmentDistribution);
        const departmentCtx = document.getElementById('departmentChart').getContext('2d');
        new Chart(departmentCtx, {
            type: 'pie',
            data: {
                labels: departmentData.map(item => item.departmentName),
                datasets: [{
                    data: departmentData.map(item => item.count),
                    backgroundColor: [
                        '#2563eb',
                        '#7c3aed',
                        '#db2777',
                        '#dc2626',
                        '#ea580c',
                        '#65a30d',
                        '#0891b2'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
    </script>
</body>
</html>
@endsection
