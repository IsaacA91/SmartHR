@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<style>
    :root {
        --primary-blue: #4849E8;
        --light-blue: #ABC4FF;
        --neon-yellow: #DDF344;
        --white: #F5F9FF;
        --card-shadow: 0 8px 16px rgba(72, 73, 232, 0.1);
    }

    .edit-form-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 2rem;
        background-color: var(--white);
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(72, 73, 232, 0.1);
    }

    .edit-form-container h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--primary-blue);
        text-align: center;
        border-bottom: 4px solid var(--primary-blue);
        padding-bottom: 0.5rem;
    }

    .employee-id-label {
        text-align: center;
        font-size: 1.1rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--primary-blue);
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 2px rgba(72, 73, 232, 0.2);
    }

    .submit-btn {
        background-color: var(--primary-blue);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .submit-btn:hover {
        background-color: #3738c7;
    }
</style>

<div class="edit-form-container">
    <h2>Edit Employee</h2>
    <div class="employee-id-label">
        Editing: <strong>{{ $employee->employeeID }}</strong>
    </div>

    <form action="{{ route('admin.employee.update', $employee->employeeID) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" value="{{ old('firstName', $employee->firstName) }}">
        </div>

        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" value="{{ old('lastName', $employee->lastName) }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $employee->email) }}">
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}">
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" value="{{ old('username', $employee->username) }}">
        </div>

        <div class="form-group">
            <label for="position">Position</label>
            <input type="text" name="position" value="{{ old('position', $employee->position) }}">
        </div>

        <div class="form-group">
            <label for="departmentID">Department</label>
            <select name="departmentID">
                @foreach ($departments as $dept)
                    <option value="{{ $dept->departmentID }}" {{ $employee->departmentID == $dept->departmentID ? 'selected' : '' }}>
                        {{ $dept->departmentName }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="baseSalary">Base Salary</label>
            <input type="number" step="0.01" name="baseSalary" value="{{ old('baseSalary', $employee->baseSalary) }}">
        </div>

        <div class="form-group">
            <label for="rate">Hourly Rate</label>
            <input type="number" step="0.01" name="rate" value="{{ old('rate', $employee->rate) }}">
        </div>

        <button type="submit" class="submit-btn">Update Employee</button>
    </form>
</div>
@endsection