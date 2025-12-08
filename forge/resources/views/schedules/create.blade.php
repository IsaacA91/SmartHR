@extends('layouts.app')
@section('title', 'Create Schedule')
@push('styles')
<style>
    body {
        background: var(--blurple);
    }

    .main-container {
        background: white;
        border-radius: 15px;
        margin: 2rem auto;
        padding: 2rem;
        max-width: 800px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .btn-primary {
        background-color: var(--blurple);
        border-color: var(--blurple);
    }
</style>
@endpush

@section('content')
<div class="main-container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Create Work Schedule</h5>
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

            <form action="{{ route('schedules.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="employeeID" class="form-label"><i class="bi bi-person"></i> Employee *</label>
                    <select name="employeeID" id="employeeID" class="form-select" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->employeeID }}" {{ old('employeeID') == $employee->employeeID ? 'selected' : '' }}>
                                {{ $employee->firstName }} {{ $employee->lastName }} ({{ $employee->employeeID }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="shiftDate" class="form-label"><i class="bi bi-calendar-date"></i> Shift Date *</label>
                    <input type="date" name="shiftDate" id="shiftDate" class="form-control" value="{{ old('shiftDate') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="shiftBegin" class="form-label"><i class="bi bi-clock"></i> Shift Start *</label>
                        <input type="time" name="shiftBegin" id="shiftBegin" class="form-control" value="{{ old('shiftBegin', '09:00') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="shiftEnd" class="form-label"><i class="bi bi-clock-fill"></i> Shift End *</label>
                        <input type="time" name="shiftEnd" id="shiftEnd" class="form-control" value="{{ old('shiftEnd', '17:00') }}" required>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Create Schedule
                    </button>
                    <a href="{{ route('schedules.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
