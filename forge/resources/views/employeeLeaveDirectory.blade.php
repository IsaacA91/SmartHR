@extends('layouts.app')

@section('title', 'My Leave Requests')

@section('content')
<style>
    :root {
        --primary-blue: #4849E8;
        --light-blue: #ABC4FF;
        --neon-yellow: #DDF344;
        --white: #F5F9FF;
        --card-shadow: 0 8px 16px rgba(72, 73, 232, 0.1);
    }

    body {
        background-color: var(--white);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--primary-blue);
    }

    .employee-table-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 2rem;
        background-color: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(72, 73, 232, 0.1);
    }

    .employee-table-container h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
        border-bottom: 4px solid var(--primary-blue);
        padding-bottom: 0.5rem;
    }

    table.employee-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 15px;
    }

    table.employee-table th {
        background-color: var(--light-blue);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--primary-blue);
    }

    table.employee-table th:first-child {
        border-radius: 8px 0 0 0;
    }

    table.employee-table th:last-child {
        border-radius: 0 8px 0 0;
    }

    table.employee-table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        color: #333;
    }

    table.employee-table tr:nth-child(even) {
        background-color: #f0f4ff;
    }

    table.employee-table tr:hover {
        background-color: #e6f0ff;
    }

    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
    }

    .status-approved {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-rejected {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #777;
    }

    .success-message {
        color: green;
        background: #d4edda;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: center;
        border: 1px solid #c3e6cb;
    }

    @media (max-width: 768px) {
        table.employee-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<div class="employee-table-container">
    <h2>My Leave Requests</h2>
    
    @if (session('success'))
        <div class="success-message">
            <h3 style='margin: 0;'>{{session('success')}}</h3>
        </div>
    @endif

    @if(count($leaveRequests) > 0)
        <table class="employee-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaveRequests as $request)
                <tr>
                    <td>Leave</td>
                    <td>{{ \Carbon\Carbon::parse($request->startDate)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($request->endDate)->format('M d, Y') }}</td>
                    <td>{{ $request->reason ?? 'N/A' }}</td>
                    <td>
                        <span class="status-badge 
                            @if($request->approval == 'Approved') status-approved
                            @elseif($request->approval == 'Rejected') status-rejected
                            @else status-pending
                            @endif">
                            {{ $request->approval }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="no-data">You have no leave requests yet. <a href="{{ route('leave.create') }}" style="color: var(--primary-blue); text-decoration: underline;">Submit your first request</a>.</p>
    @endif
</div>
@endsection
