@extends('layouts.app')

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
    <h2>Employee Directory</h2>

    @if ($employees->count())
        <table class="employee-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Joined On</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $index => $employee)
                    <tr>
                        <td>{{ $employees->firstItem() + $index }}</td>
                        <td>{{ $employee->employeeID }}</td>
                        <td>{{ $employee->firstName }} {{ $employee->lastName }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->department->departmentName ?? '—' }}</td>
                        <td>{{ $employee->position ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($employee->created_at)->format('M d, Y') }}</td>
                        <td><a href='{{ route('admin.editForm' , $employee->employeeID) }}'><button>Edit Employee Details</button></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper">
            {{ $employees->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="no-data">No employees found.</div>
    @endif
</div>
@endsection