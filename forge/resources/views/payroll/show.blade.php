<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Payroll History - SmartHR</title>
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

        .employee-header {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .employee-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .info-item {
            background-color: #f3f4f6;
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .payroll-history {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
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

        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            color: var(--primary-color);
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="payroll-container">
        <a href="{{ route('payroll.index') }}" class="back-link">&larr; Back to Payroll Overview</a>

        <div class="employee-header">
            <h1>{{ $employee->firstName }} {{ $employee->lastName }}</h1>
            <div class="employee-info">
                <div class="info-item">
                    <strong>Employee ID:</strong> {{ $employee->employeeID }}
                </div>
                <div class="info-item">
                    <strong>Position:</strong> {{ $employee->position }}
                </div>
                <div class="info-item">
                    <strong>Base Rate:</strong> ${{ number_format($employee->rate, 2) }}/hour
                </div>
                <div class="info-item">
                    <strong>Base Salary:</strong> ${{ number_format($employee->baseSalary, 2) }}
                </div>
            </div>
        </div>

        <div class="payroll-history">
            <h2>Payroll History</h2>
            @if($payrollRecords->count() > 0)
                <div class="table-responsive">
                    <table class="payroll-table">
                        <thead>
                            <tr>
                                <th>Pay Period</th>
                                <th>Regular Hours</th>
                                <th>Overtime Hours</th>
                                <th>Regular Pay</th>
                                <th>Overtime Pay</th>
                                <th>Deductions</th>
                                <th>Net Pay</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payrollRecords as $record)
                            <tr>
                                <td>
                                    {{ Carbon\Carbon::parse($record->payPeriodStart)->format('M d, Y') }} - 
                                    {{ Carbon\Carbon::parse($record->payPeriodEnd)->format('M d, Y') }}
                                </td>
                                <td>{{ number_format($record->regularHours, 2) }}</td>
                                <td>{{ number_format($record->overtimeHours, 2) }}</td>
                                <td>${{ number_format($record->regularPay, 2) }}</td>
                                <td>${{ number_format($record->overtimePay, 2) }}</td>
                                <td>${{ number_format($record->deductions, 2) }}</td>
                                <td>${{ number_format($record->netPay, 2) }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($record->status) }}">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No payroll records found.</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>