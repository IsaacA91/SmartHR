<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendance - SmartHR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #4849E8;
            --light-blue: #ABC4FF;
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
            max-width: 800px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .info-card {
            background: var(--bg-white);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    @include('layouts.adminHeader')

    <div class="main-container">
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Attendance Record - {{ $record->recordID }}</h5>
            </div>

            <div class="card-body">
                <div class="info-card">
                    <h6 class="mb-2"><i class="bi bi-person-badge"></i> Employee Information</h6>
                    <p class="mb-1"><strong>Name:</strong> {{ $record->employee->firstName }} {{ $record->employee->lastName }}</p>
                    <p class="mb-0"><strong>Employee ID:</strong> {{ $record->employeeID }}</p>
                </div>

                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> <strong>Important:</strong> Editing attendance records will recalculate hours worked automatically. Leave "Time Out" empty if the employee hasn't clocked out yet.
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('attendance.corrections.update', $record->recordID) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="workDay" class="form-label"><i class="bi bi-calendar-date"></i> Work Day *</label>
                        <input type="date" name="workDay" id="workDay" class="form-control" value="{{ old('workDay', $record->workDay->format('Y-m-d')) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="timeIn" class="form-label"><i class="bi bi-clock"></i> Time In *</label>
                            <input type="time" name="timeIn" id="timeIn" class="form-control" value="{{ old('timeIn', $record->timeIn) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="timeOut" class="form-label"><i class="bi bi-clock-fill"></i> Time Out</label>
                            <input type="time" name="timeOut" id="timeOut" class="form-control" value="{{ old('timeOut', $record->timeOut) }}">
                            <small class="text-muted">Leave empty if not clocked out</small>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>Current Hours Worked:</strong> {{ number_format($record->hoursWorked ?? 0, 2) }} hours
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Record
                        </button>
                        <a href="{{ route('attendance.corrections.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
