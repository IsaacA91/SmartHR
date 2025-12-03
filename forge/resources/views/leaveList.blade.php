@extends('layouts.adminHeader')

@section('title', 'Employee Directory')

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
        border-radius: 8px 8px 0 0;
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

    .no-data {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #777;
    }

    .pagination-wrapper {
        text-align: center;
        margin-top: 20px;
    }

    .pagination-wrapper .pagination {
        display: inline-flex;
        gap: 6px;
    }

    .pagination-wrapper .pagination li {
        display: inline;
    }

    .pagination-wrapper .pagination li a,
    .pagination-wrapper .pagination li span {
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 600;
    }

    .pagination-wrapper .pagination li.active span {
        background-color: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }
    button{
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 600;
        background-color:white;
    }
    button:hover{
        background-Color:var(--primary-blue);
        color:white;
        border-color: var(--primary-blue);
    }
    @media (max-width: 768px) {
        table.employee-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<div class="employee-table-container">
    <h2>Leave Directory</h2>
    @if (session('success'))
        <div style='color:green;'>
            <h2 style='text-align:center;'>{{session('success')}}</h2>
        </div>
    @endif
    @if(count($leaveRequests) > 0)
                <table>
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
                <p class="no-requests">No pending leave requests</p>
            @endif
        </div>
    </div>
@endsection