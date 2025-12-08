<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Corrections - SmartHR</title>
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
            margin-top: 6rem;
            padding: 2rem;
            max-width: 1400px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .nav-link {
            color: var(--primary-blue) !important;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .table-light {
            background-color: var(--bg-white) !important;
        }
    </style>
</head>
<body>
    @include('layouts.adminHeader')

    <div class="main-container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Attendance Corrections</h5>
                    <span class="badge bg-primary">{{ $records->total() }} Record(s)</span>
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
                                <th>Record ID</th>
                                <th><i class="bi bi-person"></i> Employee</th>
                                <th><i class="bi bi-calendar-date"></i> Date</th>
                                <th><i class="bi bi-clock"></i> Time In</th>
                                <th><i class="bi bi-clock-fill"></i> Time Out</th>
                                <th><i class="bi bi-hourglass"></i> Hours</th>
                                <th class="text-center"><i class="bi bi-gear"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $record->recordID }}</span></td>
                                    <td>
                                        <strong>{{ $record->employee->firstName }} {{ $record->employee->lastName }}</strong><br>
                                        <small class="text-muted">{{ $record->employeeID }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($record->workDay)->format('M d, Y') }}</td>
                                    <td>
                                        @if($record->timeIn)
                                            <span class="badge bg-info">{{ \Carbon\Carbon::parse($record->timeIn)->format('h:i A') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->timeOut)
                                            <span class="badge bg-warning text-dark">{{ \Carbon\Carbon::parse($record->timeOut)->format('h:i A') }}</span>
                                        @else
                                            <span class="badge bg-danger">Not clocked out</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->hoursWorked)
                                            {{ number_format($record->hoursWorked, 2) }} hrs
                                        @else
                                            <span class="text-muted">0.00 hrs</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('attendance.corrections.edit', $record->recordID) }}" 
                                               class="btn btn-sm btn-primary"
                                               title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('attendance.corrections.destroy', $record->recordID) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                        <p class="mt-2 text-muted">No attendance records found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($records->hasPages())
                    <div class="mt-4">
                        {{ $records->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
