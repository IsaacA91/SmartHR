<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule - SmartHR</title>
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
    </style>
</head>
<body>
    @include('layouts.adminHeader')

    <div class="main-container">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Schedule - {{ $schedule->scheduleID }}</h5>
            </div>

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('schedules.update', $schedule->scheduleID) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="employeeID" class="form-label"><i class="bi bi-person"></i> Employee *</label>
                        <select name="employeeID" id="employeeID" class="form-select" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->employeeID }}" {{ old('employeeID', $schedule->employeeID) == $employee->employeeID ? 'selected' : '' }}>
                                    {{ $employee->firstName }} {{ $employee->lastName }} ({{ $employee->employeeID }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="shiftDate" class="form-label"><i class="bi bi-calendar-date"></i> Shift Date *</label>
                        <input type="date" name="shiftDate" id="shiftDate" class="form-control" value="{{ old('shiftDate', $schedule->shiftDate->format('Y-m-d')) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="shiftBegin" class="form-label"><i class="bi bi-clock"></i> Shift Start *</label>
                            <input type="time" name="shiftBegin" id="shiftBegin" class="form-control" value="{{ old('shiftBegin', $schedule->shiftBegin) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="shiftEnd" class="form-label"><i class="bi bi-clock-fill"></i> Shift End *</label>
                            <input type="time" name="shiftEnd" id="shiftEnd" class="form-control" value="{{ old('shiftEnd', $schedule->shiftEnd) }}" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Schedule
                        </button>
                        <a href="{{ route('schedules.index') }}" class="btn btn-secondary">
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
