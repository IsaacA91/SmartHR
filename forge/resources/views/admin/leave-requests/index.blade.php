<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Requests - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --danger-color: #dc2626;
            --success-color: #16a34a;
        }
        
        body {
            background-color: #f3f4f6;
            font-family: system-ui, -apple-system, sans-serif;
        }
        
        .leave-requests-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1.5rem;
        }
        
        .leave-request-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .btn-approve {
            background-color: var(--success-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn-reject {
            background-color: var(--danger-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .remarks-input {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="leave-requests-container">
        <h2 class="mb-4">Pending Leave Requests</h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @foreach($leaveRequests as $request)
            <div class="leave-request-card">
                <div class="row">
                    <div class="col-md-8">
                        <h5>{{ $request->employee->firstName }} {{ $request->employee->lastName }}</h5>
                        <p>Employee ID: {{ $request->employeeID }}</p>
                        <p>From: {{ $request->startDate->format('M d, Y') }} - To: {{ $request->endDate->format('M d, Y') }}</p>
                        <p>Reason: {{ $request->reason }}</p>
                        <p>Total Days: {{ $request->getTotalDaysAttribute() }}</p>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('admin.leave-requests.update-status', $request->leaveRecordID) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="admin_remarks" class="form-label">Remarks (optional)</label>
                                <textarea name="admin_remarks" id="admin_remarks" class="remarks-input" rows="2"></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" name="status" value="approved" class="btn-approve">Approve</button>
                                <button type="submit" name="status" value="rejected" class="btn-reject">Reject</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        {{ $leaveRequests->links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>