@extends('layouts.adminHeader')

@section('title', 'Leave Requests')

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
        max-width: 1400px;
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

    .form-select {
        padding: 0.4rem 0.6rem;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .form-select:hover {
        border-color: var(--primary-blue);
    }

    .form-select:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(72, 73, 232, 0.1);
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

    .search-container {
        margin-bottom: 1.5rem;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-container input {
        flex: 1;
        padding: 10px 15px;
        border: 2px solid var(--light-blue);
        border-radius: 8px;
        font-size: 1rem;
        color: var(--primary-blue);
    }

    .search-container input:focus {
        outline: none;
        border-color: var(--primary-blue);
    }

    .search-container button {
        padding: 10px 20px;
        border: 2px solid var(--primary-blue);
        border-radius: 6px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 600;
        background-color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-container button:hover {
        background-color: var(--primary-blue);
        color: white;
    }

    .search-container a button {
        padding: 10px 20px;
        border: 2px solid #6c757d;
        color: #6c757d;
    }

    .search-container a button:hover {
        background-color: #6c757d;
        color: white;
        border-color: #6c757d;
    }

    @media (max-width: 768px) {
        table.employee-table {
            display: block;
            overflow-x: auto;
        }

        .search-container {
            flex-direction: column;
        }

        .search-container input {
            width: 100%;
        }
    }
</style>

<div class="employee-table-container">
    <h2>Leave Request Directory</h2>
    
    @if (session('success'))
        <div class="success-message">
            <h2 style='margin: 0;'>{{session('success')}}</h2>
        </div>
    @endif

    <div class="search-container">
        <form method="GET" action="{{ route('admin.leave.directory') }}" style="display: flex; gap: 10px; width: 100%;">
            <input 
                type="text" 
                name="search" 
                placeholder="Search by employee name, employee ID, or status..." 
                value="{{ request('search') }}"
                autocomplete="off"
            >
            <button type="submit">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.leave.directory') }}"><button type="button">Clear</button></a>
            @endif
        </form>
    </div>

    @if(count($leaveRequests) > 0)
        <table class="employee-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaveRequests as $request)
                <tr>
                    <td>{{ $request->firstName }} {{ $request->lastName }}</td>
                    <td>Leave</td>
                    <td>{{ \Carbon\Carbon::parse($request->startDate)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($request->endDate)->format('M d, Y') }}</td>
                    <td>
                        <form action="{{ route('admin.leave-requests.update-status', $request->leaveRecordID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <select name="approval" onchange="this.form.submit()" class="form-select">
                                <option value="Pending" {{ $request->approval == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option style='color:Green' value="Approved" {{ $request->approval == 'Approved' ? 'selected' : '' }}>Approve</option>
                                <option style='color:Red' value="Rejected" {{ $request->approval == 'Rejected' ? 'selected' : '' }}>Reject</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="no-data">No leave requests found</p>
    @endif
</div>
@endsection
