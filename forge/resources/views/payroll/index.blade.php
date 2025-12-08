@extends('layouts.adminHeader')

@section('title', 'Payroll Management')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Management - SmartHR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #818cf8;
            --success-color: #22c55e;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --background-color: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: #1f2937;
        }

        .payroll-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1.5rem;
        }

        .payroll-header {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .payroll-header h1 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .payroll-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .summary-card h3 {
            color: var(--primary-color);
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .summary-card p {
            color: #6b7280;
            margin: 0;
        }

        .search-bar {
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-bar input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .search-bar button {
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .search-bar button:hover {
            background-color: var(--secondary-color);
        }

        .table-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .payroll-table {
            width: 100%;
            border-collapse: collapse;
        }

        .payroll-table th {
            background-color: #f3f4f6;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
        }

        .payroll-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .payroll-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .employee-name {
            font-weight: 600;
            color: #1f2937;
        }

        .employee-id {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .hours-cell {
            text-align: center;
        }

        .money-cell {
            font-weight: 600;
            color: #059669;
        }

        .btn-process {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-process:hover {
            background-color: var(--secondary-color);
        }

        .btn-view {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background-color 0.2s;
            margin-right: 0.5rem;
            text-decoration: none;
            display: inline-block;
        }

        .btn-view:hover {
            background-color: #d1d5db;
            color: #374151;
        }

        .no-data {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .overtime-badge {
            background-color: #fef3c7;
            color: #92400e;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="payroll-container">
        <div class="payroll-header">
            <h1><i class="bi bi-cash-stack"></i> Payroll Management</h1>
            <p>Pay Period: {{ $periodStart->format('M d, Y') }} - {{ $periodEnd->format('M d, Y') }}</p>
        </div>

        <div class="payroll-summary">
            <div class="summary-card">
                <h3>{{ count($payrollData) }}</h3>
                <p>Total Employees</p>
            </div>
            <div class="summary-card">
                <h3>${{ number_format(collect($payrollData)->sum('totalPay'), 2) }}</h3>
                <p>Total Payroll</p>
            </div>
            <div class="summary-card">
                <h3>{{ number_format(collect($payrollData)->sum('regularHours'), 1) }}</h3>
                <p>Total Regular Hours</p>
            </div>
            <div class="summary-card">
                <h3>{{ number_format(collect($payrollData)->sum('overtimeHours'), 1) }}</h3>
                <p>Total Overtime Hours</p>
            </div>
        </div>

        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search by employee name or ID..." onkeyup="searchTable()">
            <button onclick="searchTable()"><i class="bi bi-search"></i> Search</button>
        </div>

        <div class="table-container">
            <table class="payroll-table" id="payrollTable">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th class="hours-cell">Regular Hrs</th>
                        <th class="hours-cell">Overtime Hrs</th>
                        <th>Base Salary</th>
                        <th>Overtime Pay</th>
                        <th>Total Pay</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrollData as $data)
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">
                                        {{ strtoupper(substr($data['employee']->firstName, 0, 1)) }}{{ strtoupper(substr($data['employee']->lastName, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="employee-name">{{ $data['employee']->firstName }} {{ $data['employee']->lastName }}</div>
                                        <div class="employee-id">{{ $data['employee']->employeeID }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $data['employee']->department->departmentName ?? '—' }}</td>
                            <td class="hours-cell">{{ number_format($data['regularHours'], 1) }}</td>
                            <td class="hours-cell">
                                {{ number_format($data['overtimeHours'], 1) }}
                                @if($data['overtimeHours'] > 0)
                                    <span class="overtime-badge">OT</span>
                                @endif
                            </td>
                            <td class="money-cell">${{ number_format($data['regularPay'], 2) }}</td>
                            <td class="money-cell">${{ number_format($data['overtimePay'], 2) }}</td>
                            <td class="money-cell">${{ number_format($data['totalPay'], 2) }}</td>
                            <td>
                                <a href="{{ route('admin.payroll.show', $data['employee']->employeeID) }}" class="btn-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <form action="{{ route('admin.payroll.process') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="employeeID" value="{{ $data['employee']->employeeID }}">
                                    <input type="hidden" name="periodStart" value="{{ $periodStart->format('Y-m-d') }}">
                                    <input type="hidden" name="periodEnd" value="{{ $periodEnd->format('Y-m-d') }}">
                                    <button type="submit" class="btn-process">
                                        <i class="bi bi-check-circle"></i> Process
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="no-data">
                                <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                No employees found for this pay period.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('payrollTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent || cells[j].innerText;
                    if (cellText.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }

                rows[i].style.display = found ? '' : 'none';
            }
        }
    </script>
</body>
</html>
@endsection
