<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip Details - SmartHR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            color: #333;
        }

        .navbar {
            background: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: var(--primary-blue) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .main-container {
            background: white;
            border-radius: 15px;
            margin: 2rem auto;
            padding: 2rem;
            max-width: 1200px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .nav-link {
            color: var(--primary-blue) !important;
        }

        .nav-link:hover {
            color: var(--light-blue) !important;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-primary:hover {
            background-color: #3a3bc7;
            border-color: #3a3bc7;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .table {
            background: white;
        }

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-header {
            background: var(--bg-white);
            border-bottom: 2px solid var(--primary-blue);
        }

        .table-primary {
            background-color: var(--bg-white) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('attendance.dashboard') }}">SmartHR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('attendance.dashboard') }}">
                            <i class="bi bi-clock-history"></i> Attendance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('leave.index') }}">
                            <i class="bi bi-calendar-x"></i> Leave Requests
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('employee.payroll.index') }}">
                            <i class="bi bi-cash-coin"></i> Payroll
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('employee.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-file-text"></i> Payslip Details</h5>
                <div>
                    <a href="{{ route('payslip.generate', [$employee->employeeID, $payslip->payPeriodBeginning->format('n'), $payslip->payPeriodBeginning->format('Y')]) }}" 
                       class="btn btn-success btn-sm me-2"
                       target="_blank">
                        <i class="bi bi-file-pdf-fill"></i> Download PDF
                    </a>
                    <a href="{{ route('employee.payroll.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title"><i class="bi bi-person-badge"></i> Employee Information</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="40%">Employee ID:</th>
                                        <td>{{ $employee->employeeID }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $employee->firstName }} {{ $employee->lastName }}</td>
                                    </tr>
                                    <tr>
                                        <th>Position:</th>
                                        <td>{{ $employee->position }}</td>
                                    </tr>
                                    <tr>
                                        <th>Base Salary:</th>
                                        <td><strong class="text-success">₱{{ number_format($employee->baseSalary, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Hourly Rate:</th>
                                        <td><strong>₱{{ number_format($employee->rate, 2) }}/hr</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title"><i class="bi bi-calendar-range"></i> Pay Period Information</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="40%">Period Start:</th>
                                        <td>{{ $payslip->payPeriodBeginning->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Period End:</th>
                                        <td>{{ $payslip->payPeriodEnd->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slip ID:</th>
                                        <td><span class="badge bg-secondary">{{ $payslip->slipID }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Regular Hours:</th>
                                        <td><span class="badge bg-info">{{ number_format($payslip->regularHours ?? 0, 1) }} hrs</span></td>
                                    </tr>
                                    <tr>
                                        <th>Overtime Hours:</th>
                                        <td><span class="badge bg-warning text-dark">{{ number_format($payslip->overtimeHours, 1) }} hrs</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="bi bi-cash-coin"></i> Earnings Breakdown</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm mb-0">
                                    <tr>
                                        <th>Base Salary:</th>
                                        <td class="text-end">₱{{ number_format($employee->baseSalary, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Overtime Pay:</th>
                                        <td class="text-end">₱{{ number_format($payslip->overtimeHours * $employee->rate, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th><small class="text-muted">({{ number_format($payslip->overtimeHours, 1) }} hrs × ₱{{ number_format($employee->rate, 2) }}/hr)</small></th>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="bi bi-wallet2"></i> Total Compensation</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center py-3">
                                    <h6 class="text-muted mb-2">Total Pay for Period</h6>
                                    <h2 class="text-success mb-0">₱{{ number_format($payslip->totalPayForPeriod, 2) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>