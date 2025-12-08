<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Payroll - SmartHR</title>
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
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-receipt"></i> My Payroll History</h5>
                    <span class="badge bg-primary">{{ $payslips->total() }} Record(s)</span>
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><i class="bi bi-calendar-range"></i> Pay Period</th>
                                <th><i class="bi bi-clock"></i> Regular Hours</th>
                                <th><i class="bi bi-clock-history"></i> Overtime Hours</th>
                                <th><i class="bi bi-cash-stack"></i> Total Pay</th>
                                <th class="text-center"><i class="bi bi-gear"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payslips as $payslip)
                                <tr>
                                    <td>
                                        <strong>{{ $payslip->payPeriodBeginning->format('M d, Y') }}</strong><br>
                                        <small class="text-muted">to {{ $payslip->payPeriodEnd->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ number_format($payslip->regularHours ?? 0, 1) }} hrs</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ number_format($payslip->overtimeHours, 1) }} hrs</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">₱{{ number_format($payslip->totalPayForPeriod, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('employee.payroll.show', $payslip->slipID) }}" 
                                               class="btn btn-sm btn-primary"
                                               title="View Details">
                                                <i class="bi bi-eye-fill"></i> View
                                            </a>
                                            <a href="{{ route('payslip.generate', [$payslip->employeeID, $payslip->payPeriodBeginning->format('n'), $payslip->payPeriodBeginning->format('Y')]) }}" 
                                               class="btn btn-sm btn-success"
                                               target="_blank"
                                               title="Download PDF">
                                                <i class="bi bi-file-pdf-fill"></i> PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                        <p class="mt-2 text-muted">No payroll records found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($payslips->hasPages())
                    <div class="mt-4">
                        {{ $payslips->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>