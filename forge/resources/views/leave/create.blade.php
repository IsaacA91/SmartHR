<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Leave Request - SmartHR</title>
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

        .leave-card {
            background: var(--bg-white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }

        .form-label {
            font-weight: 500;
            color: var(--primary-blue);
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-primary:hover {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .btn-outline-secondary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-outline-secondary:hover {
            background-color: var(--primary-blue);
            color: var(--bg-white);
        }

        .form-control:focus {
            border-color: var(--light-blue);
            box-shadow: 0 0 0 0.25rem rgba(72, 73, 232, 0.25);
        }

        .form-text {
            color: var(--primary-blue) !important;
        }

        .alert-danger {
            background-color: var(--light-blue);
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .bi {
            color: inherit;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="leave-card">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="bi bi-calendar-plus"></i> New Leave Request</h2>
                        <a href="{{ route('leave.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Leave Requests
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Leave Request Form -->
                    <form action="{{ route('leave.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                    value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                    value="{{ old('end_date') }}" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-12">
                                <label for="reason" class="form-label">Reason for Leave</label>
                                <textarea class="form-control" id="reason" name="reason" rows="4" 
                                    placeholder="Please provide a detailed reason for your leave request" 
                                    required>{{ old('reason') }}</textarea>
                                <div class="form-text">
                                    Minimum 10 characters. Please be specific about your leave reason.
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Submit Leave Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ensure end date is not before start date
        document.getElementById('start_date').addEventListener('change', function() {
            document.getElementById('end_date').min = this.value;
        });
    </script>
</body>
</html>