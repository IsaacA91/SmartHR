@extends('layouts.adminHeader')

@section('title', 'Dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-blue: #4849E8;
            --light-blue: #ABC4FF;
            --neon-yellow: #DDF344;
            --white: #F5F9FF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--white);
            color: var(--primary-blue);
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background shapes */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            animation: float 20s infinite ease-in-out;
        }

        .shape1 {
            width: 400px;
            height: 400px;
            background: var(--light-blue);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .shape2 {
            width: 350px;
            height: 350px;
            background: var(--primary-blue);
            bottom: -100px;
            left: -100px;
            animation-delay: 7s;
        }

        .shape3 {
            width: 300px;
            height: 300px;
            background: var(--neon-yellow);
            top: 50%;
            right: 20%;
            animation-delay: 14s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -30px) rotate(90deg); }
            50% { transform: translate(-20px, 20px) rotate(180deg); }
            75% { transform: translate(40px, 10px) rotate(270deg); }
        }

        .container {
            max-width: 95%;
            margin: 0 auto;
            padding: 1.5rem;
            padding-top: 2.5rem;
            position: relative;
            z-index: 1;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            border-bottom: 4px solid var(--primary-blue);
            padding-bottom: 0.75rem;
            animation: slideDown 0.8s ease-out;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 8px 24px rgba(72, 73, 232, 0.1);
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            animation: cardSlideIn 0.6s ease-out both;
        }

        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }
        .stats-card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes cardSlideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--light-blue));
            transition: height 0.4s ease;
        }

        .stats-card:hover::before {
            height: 100%;
            opacity: 0.05;
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(72, 73, 232, 0.2);
            border-color: rgba(72, 73, 232, 0.3);
        }

        .stats-card h3 {
            color: var(--primary-blue);
            margin: 0 0 1rem 0;
            font-size: 0.95rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
        }

        .stats-number {
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
        }

        button {
            padding: 0.75rem 1.5rem;
            border: 2px solid var(--primary-blue);
            border-radius: 10px;
            color: var(--primary-blue);
            font-weight: 600;
            background-color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: var(--primary-blue);
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
            z-index: -1;
        }

        button:hover::before {
            width: 300px;
            height: 300px;
        }

        button:hover {
            color: white;
            border-color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 73, 232, 0.3);
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin: 1.5rem 0;
        }

        .chart-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1.25rem;
            box-shadow: 0 8px 24px rgba(72, 73, 232, 0.1);
            border: 1px solid rgba(72, 73, 232, 0.1);
            animation: fadeIn 1s ease-out 0.5s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .chart-container h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .leave-requests {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 8px 24px rgba(72, 73, 232, 0.1);
            border: 1px solid rgba(72, 73, 232, 0.1);
            margin: 1.5rem 0 0 0;
            animation: fadeIn 1s ease-out 0.7s both;
        }

        .leave-requests h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1rem;
        }

        th {
            background: linear-gradient(135deg, var(--light-blue), rgba(171, 196, 255, 0.5));
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--primary-blue);
            border-radius: 8px 8px 0 0;
        }

        td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(72, 73, 232, 0.1);
            background: rgba(255, 255, 255, 0.5);
        }

        tr:hover td {
            background: rgba(171, 196, 255, 0.1);
        }

        .no-requests {
            color: #64748b;
            font-style: italic;
            text-align: center;
            padding: 1.5rem;
        }

        select {
            outline: 0;
            padding: 0.5rem 1rem;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            cursor: pointer;
            border-radius: 8px;
            background: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        select:hover {
            background: var(--primary-blue);
            color: white;
        }

        .success-message {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border-left: 4px solid #22c55e;
            margin-bottom: 1.5rem;
            font-weight: 600;
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
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

            h1 {
                font-size: 2rem;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Animated background -->
    <div class="bg-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
    </div>

    <div class="container">
        @if (session('success'))
            <div class="success-message">
                <i class="bi bi-check-circle-fill"></i> {{session('success')}}
            </div>
        @endif

        <h1>{{$companyName}}</h1>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <form class="stats-card" method='get' action="{{ route('admin.employeeList') }}">
                @csrf
                <h3><i class="bi bi-people-fill"></i> Total Employees</h3>
                <div class="stats-number">{{ $totalEmployees }}</div>
                <button type="submit">View All</button>
            </form>
            <form class="stats-card" method='get' action="{{route('admin.presentList')}}">
                @csrf
                <h3><i class="bi bi-calendar-check"></i> Present Today</h3>
                <div class="stats-number">{{ $presentToday }}</div>
                <button type="submit">View All</button>
            </form>
            <form class="stats-card" method='get' action="{{ route('admin.payroll.index') }}">
                @csrf
                <h3><i class="bi bi-cash-coin"></i> Payroll (Month)</h3>
                <div class="stats-number">${{ number_format($totalPayroll, 0) }}</div>
                <button type="submit">Manage Payroll</button>
            </form>
            <div class="stats-card">
                <h3><i class="bi bi-calendar-x"></i> Absent Today</h3>
                <div class="stats-number">{{ $absentToday }}</div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <div class="chart-container">
                <h3><i class="bi bi-graph-up"></i> Attendance Trends</h3>
                <canvas id="attendanceChart"></canvas>
            </div>
            <div class="chart-container">
                <h3><i class="bi bi-pie-chart-fill"></i> Department Distribution</h3>
                <canvas id="departmentChart"></canvas>
            </div>
        </div>

        <!-- Leave Requests -->
        <div class="leave-requests">
            <h3><i class="bi bi-clock-history"></i> Recent Leave Requests</h3>
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
                            <td><strong>{{ $request->firstName }} {{ $request->lastName }}</strong></td>
                            <td>Leave</td>
                            <td>{{ \Carbon\Carbon::parse($request->startDate)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($request->endDate)->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('admin.leave-requests.update-status', $request->leaveRecordID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="approval" onchange="this.form.submit()">
                                        <option value="Pending" {{ $request->approval == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option style='color:Green' value="Approved" {{ $request->approval == 'Approved' ? 'selected' : '' }}>Approve</option>
                                        <option style='color:Red' value="Rejected" {{ $request->approval == 'Rejected' ? 'selected' : '' }}>Reject</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="no-requests"><i class="bi bi-inbox"></i> No recent leave requests</p>
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
                        '#2556ebff',
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