@extends('layouts.app')
@section('title', 'Bulk Create Schedules')
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
        max-width: 900px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .btn-primary, .btn-success {
        background-color: var(--blurple);
        border-color: var(--blurple);
    }
</style>
@endpush

@section('content')
<div class="main-container">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-plus"></i> Bulk Create Schedules</h5>
        </div>

        <div class="card-body">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Create multiple schedule entries for an employee across a date range and selected days of the week.
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('schedules.bulk-store') }}" method="POST">
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

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label"><i class="bi bi-calendar"></i> Start Date *</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label"><i class="bi bi-calendar-check"></i> End Date *</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    </div>
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

                <div class="mb-4">
                    <label class="form-label"><i class="bi bi-calendar-week"></i> Days of Week *</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="days_of_week[]" value="1" id="monday" {{ in_array('1', old('days_of_week', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="monday">Monday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="days_of_week[]" value="2" id="tuesday" {{ in_array('2', old('days_of_week', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tuesday">Tuesday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="days_of_week[]" value="3" id="wednesday" {{ in_array('3', old('days_of_week', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="wednesday">Wednesday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="days_of_week[]" value="4" id="thursday" {{ in_array('4', old('days_of_week', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="thursday">Thursday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="days_of_week[]" value="5" id="friday" {{ in_array('5', old('days_of_week', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="friday">Friday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="days_of_week[]" value="6" id="saturday" {{ in_array('6', old('days_of_week', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="saturday">Saturday</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="days_of_week[]" value="0" id="sunday" {{ in_array('0', old('days_of_week', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="sunday">Sunday</label>
                        </div>
                    </div>
                    <small class="text-muted">Select at least one day of the week</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Create Schedules
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
