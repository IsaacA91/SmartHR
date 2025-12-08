<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Requests - SmartHR</title>
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
        
        .leave-card {
            background: var(--bg-white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .btn-primary:hover {
            background-color: #3a3bd0;
            border-color: #3a3bd0;
        }
        
        .btn-outline-secondary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .table {
            --bs-table-hover-bg: var(--bg-white);
            --bs-table-hover-color: var(--primary-blue);
        }
        
        .status-badge {
            font-size: 0.9rem;
            padding: 5px 15px;
            border-radius: 50px;
        }
        
        .status-pending { 
            background-color: var(--accent-yellow); 
            color: #333;
        }
        
        .status-approved { 
            background-color: var(--primary-blue); 
            color: var(--bg-white);
        }
        
        .status-rejected { 
            background-color: var(--light-blue); 
            color: var(--primary-blue);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            color: var(--bg-white);
        }
        
        .pagination .page-link {
            color: var(--primary-blue);
        }
        
        .text-primary {
            color: var(--primary-blue) !important;
        }
        
        .text-muted {
            color: var(--light-blue) !important;
        }

        .alert-success {
            background-color: var(--accent-yellow);
            border-color: var(--accent-yellow);
            color: #333;
        }

        .btn-info {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .btn-info:hover {
            background-color: var(--accent-yellow);
            border-color: var(--accent-yellow);
            color: #333;
        }

        .btn-danger {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .btn-danger:hover {
            background-color: var(--accent-yellow);
            border-color: var(--accent-yellow);
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="leave-card">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="bi bi-calendar-x"></i> Leave Requests</h2>
                        <div>
                            <a href="{{ route('attendance.dashboard') }}" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-arrow-left"></i> Back to Dashboard
                            </a>
                            <a href="{{ route('leave.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i> New Leave Request
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Leave Requests Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Request Date</th>
                                    <th>Leave Period</th>
                                    <th>Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaveRequests as $request)
                                    <tr>
                                        <td>{{ $request->startDate?->format('M d, Y') ?? 'N/A' }}</td>
                                        <td>
                                            {{ $request->startDate?->format('M d, Y') ?? 'N/A' }}
                                            <br>
                                            <small class="text-muted">to</small>
                                            <br>
                                            {{ $request->endDate?->format('M d, Y') ?? 'N/A' }}
                                        </td>
                                        <td>{{ $request->getTotalDaysAttribute() }}</td>
                                        <td>
                                            {{ Str::limit($request->reason, 30) }}
                                            @if(strlen($request->reason) > 30)
                                                <a href="{{ route('leave.show', $request) }}" class="text-primary">...</a>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge status-badge status-{{ strtolower($request->approval) }}">
                                                {{ $request->approval }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('leave.show', $request) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($request->approval === 'Pending')
                                                <form action="{{ route('leave.cancel', $request) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this leave request?')">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="bi bi-inbox text-muted d-block mb-2" style="font-size: 2rem;"></i>
                                            No leave requests found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $leaveRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>