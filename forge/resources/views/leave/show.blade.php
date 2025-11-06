<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Details - SmartHR</title>
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

        .status-badge {
            font-size: 1rem;
            padding: 8px 20px;
            border-radius: 50px;
        }

        .status-pending { 
            background-color: var(--accent-yellow); 
            color: var(--primary-blue);
        }

        .status-approved { 
            background-color: var(--primary-blue); 
            color: var(--bg-white);
        }

        .status-rejected { 
            background-color: var(--light-blue); 
            color: var(--primary-blue);
        }

        .detail-label {
            font-weight: 500;
            color: var(--primary-blue);
        }

        .card {
            background-color: var(--bg-white);
            border: 1px solid var(--light-blue);
        }

        .btn-outline-secondary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-outline-secondary:hover {
            background-color: var(--primary-blue);
            color: var(--bg-white);
        }

        .btn-danger {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .btn-danger:hover {
            background-color: var(--accent-yellow);
            border-color: var(--accent-yellow);
            color: var(--primary-blue);
        }

        h2 {
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
                        <h2><i class="bi bi-calendar-event"></i> Leave Request Details</h2>
                        <a href="{{ route('leave.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Leave Requests
                        </a>
                    </div>

                    <!-- Status Badge -->
                    <div class="text-center mb-4">
                        <span class="badge status-badge status-{{ $leaveRequest->status }}">
                            {{ ucfirst($leaveRequest->status) }}
                        </span>
                    </div>

                    <!-- Leave Details -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="detail-label mb-1">Start Date</p>
                                    <p class="mb-0">{{ $leaveRequest->start_date->format('M d, Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="detail-label mb-1">End Date</p>
                                    <p class="mb-0">{{ $leaveRequest->end_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="detail-label mb-1">Total Days</p>
                                    <p class="mb-0">{{ $leaveRequest->total_days }} day(s)</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="detail-label mb-1">Request Date</p>
                                    <p class="mb-0">{{ $leaveRequest->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="detail-label mb-1">Reason for Leave</p>
                                <p class="mb-0">{{ $leaveRequest->reason }}</p>
                            </div>
                            @if($leaveRequest->admin_remarks)
                                <div class="mb-0">
                                    <p class="detail-label mb-1">Admin Remarks</p>
                                    <p class="mb-0">{{ $leaveRequest->admin_remarks }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    @if($leaveRequest->status === 'pending')
                        <div class="text-center">
                            <form action="{{ route('leave.cancel', $leaveRequest) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this leave request?')">
                                    <i class="bi bi-x-lg"></i> Cancel Request
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>