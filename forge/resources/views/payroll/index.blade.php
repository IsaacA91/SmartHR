<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Management - SmartHR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .payroll-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .payroll-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background-color: #f3f4f6;
            padding: 1rem;
            border-radius: 0.5rem;
            text-align: center;
        }

        .summary-card h3 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .table-container {
            overflow-x: auto;
        }

        .payroll-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .payroll-table th {
            background-color: #f3f4f6;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        .payroll-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-processed {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-paid {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .btn-process {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-process:hover {
            background-color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="payroll-container">
        <div class="payroll-header">
            <h1>Payroll Management</h1>
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
                <h3>{{ number_format(collect($payrollData)->sum('regularHours')) }}</h3>
                <p>Total Regular Hours</p>
            </div>
            <div class="summary-card">
                <h3>{{ number_format(collect($payrollData)->sum('overtimeHours')) }}</h3>
                <p>Total Overtime Hours</p>
            </div>
        </div>

        <div class="payroll-card">
            <div class="table-container">
                <table class="payroll-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Regular Hours</th>
                            <th>Overtime Hours</th>
                            <th>Regular Pay</th>
                            <th>Overtime Pay</th>
                            <th>Total Pay</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payrollData as $data)
                        <tr>
                            <td>{{ $data['employee']->firstName }} {{ $data['employee']->lastName }}</td>
                            <td>{{ number_format($data['regularHours'], 2) }}</td>
                            <td>{{ number_format($data['overtimeHours'], 2) }}</td>
                            <td>${{ number_format($data['regularPay'], 2) }}</td>
                            <td>${{ number_format($data['overtimePay'], 2) }}</td>
                            <td>${{ number_format($data['totalPay'], 2) }}</td>
                            <td>
                                <form action="{{ route('payroll.process') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="employeeID" value="{{ $data['employee']->employeeID }}">
                                    <input type="hidden" name="periodStart" value="{{ $periodStart->format('Y-m-d') }}">
                                    <input type="hidden" name="periodEnd" value="{{ $periodEnd->format('Y-m-d') }}">
                                    <button type="submit" class="btn-process">Process Payroll</button>
                                </form>
                                <a href="{{ route('payroll.show', $data['employee']->employeeID) }}" class="btn btn-link">View History</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>