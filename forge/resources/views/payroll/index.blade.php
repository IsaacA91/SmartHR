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
            background: #e60012;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 0;
            border: 2px solid #ffffff;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.5);
        }

        .btn-process:hover {
            background: #ffffff;
            color: #e60012;
            transform: translate(-2px, -2px);
            box-shadow: 5px 5px 0 rgba(230, 0, 18, 0.5);
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
            border: 2px solid #e60012;
            border-radius: 0;
            font-size: 1rem;
            background-color: #1a1a1a;
            color: var(--text-primary);
            box-shadow: 3px 3px 0 rgba(230, 0, 18, 0.3);
        }

        .search-bar input:focus {
            outline: none;
            border-color: #ff0033;
            box-shadow: 5px 5px 0 rgba(230, 0, 18, 0.5);
            background-color: #000000;
        }

        .search-bar button {
            padding: 0.75rem 1.5rem;
            background: #e60012;
            color: white;
            border: 2px solid #ffffff;
            border-radius: 0;
            cursor: pointer;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s;
            box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.5);
        }

        .search-bar button:hover {
            background: #ffffff;
            color: #e60012;
            transform: translate(-2px, -2px);
            box-shadow: 5px 5px 0 rgba(230, 0, 18, 0.5);
        }
    </style>
</head>
<body>
    <div class="payroll-container">
        <div class="payroll-header">
            <h1><i class="bi bi-cash-stack"></i> Payroll Management</h1>
            <p>Pay Period: {{ $periodStart->format('M d, Y') }} - {{ $periodEnd->format('M d, Y') }}</p>
        </div>

        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search by employee name or ID..." onkeyup="searchTable()">
            <button onclick="searchTable()"><i class="bi bi-search"></i> Search</button>
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
                <h3>{{ number_format(collect($payrollData)->sum('regularHours'), 2) }}</h3>
                <p>Total Regular Hours</p>
            </div>
            <div class="summary-card">
                <h3>{{ number_format(collect($payrollData)->sum('overtimeHours'), 2) }}</h3>
                <p>Total Overtime Hours</p>
            </div>
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
        }

        .search-bar button:hover {
            background-color: var(--secondary-color);
        }           } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>
</html>
@endsection