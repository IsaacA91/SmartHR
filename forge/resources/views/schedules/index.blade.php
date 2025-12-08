@extends('layouts.app')
@section('title', 'Work Schedules')
@push('styles')
<style>
    :root {
        --primary-blue: #4849E8;
        --light-blue: #ABC4FF;
        --accent-yellow: #DDF344;
        --bg-white: #F5F9FF;
    }
    
    body {
        background: var(--blurple);
    }

    .main-container {
        background: white;
        border-radius: 15px;
        margin: 2rem auto;
        padding: 2rem;
        max-width: 1400px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .btn-primary {
        background-color: var(--primary-blue);
        border-color: var(--primary-blue);
    }

    .btn-primary:hover {
        background-color: #3a3bc7;
        border-color: #3a3bc7;
    }

    .table-light {
        background-color: var(--bg-white) !important;
    }
</style>
@endpush

@section('content')
    <div class="main-container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-calendar-week"></i> Work Schedules</h5>
                    <div>
                        <a href="{{ route('schedules.bulk-create') }}" class="btn btn-success btn-sm me-2">
                            <i class="bi bi-calendar-plus"></i> Bulk Create
                        </a>
                        <a href="{{ route('schedules.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Schedule
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Schedule ID</th>
                                <th><i class="bi bi-person"></i> Employee</th>
                                <th><i class="bi bi-calendar-date"></i> Date</th>
                                <th><i class="bi bi-clock"></i> Shift Start</th>
                                <th><i class="bi bi-clock-fill"></i> Shift End</th>
                                <th><i class="bi bi-hourglass"></i> Duration</th>
                                <th class="text-center"><i class="bi bi-gear"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedules as $schedule)
                                @php
                                    $start = \Carbon\Carbon::parse($schedule->shiftBegin);
                                    $end = \Carbon\Carbon::parse($schedule->shiftEnd);
                                    $duration = $start->diffInHours($end);
                                @endphp
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $schedule->scheduleID }}</span></td>
                                    <td>
                                        <strong>{{ $schedule->employee->firstName }} {{ $schedule->employee->lastName }}</strong><br>
                                        <small class="text-muted">{{ $schedule->employeeID }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->shiftDate)->format('M d, Y') }}</td>
                                    <td><span class="badge bg-info">{{ $start->format('h:i A') }}</span></td>
                                    <td><span class="badge bg-warning text-dark">{{ $end->format('h:i A') }}</span></td>
                                    <td>{{ $duration }} hours</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('schedules.edit', $schedule->scheduleID) }}" 
                                               class="btn btn-sm btn-primary"
                                               title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('schedules.destroy', $schedule->scheduleID) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                        <p class="mt-2 text-muted">No schedules found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($schedules->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $schedules->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
