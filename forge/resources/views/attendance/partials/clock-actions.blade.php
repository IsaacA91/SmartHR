<!-- Clock Actions -->
<div class="text-center mb-4">
    <div class="clock-display mb-3" id="currentTime"></div>
    
    @if(!$latestRecord || $latestRecord->timeOut)
        <form action="{{ route('attendance.clock') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="clock_in">
            <button type="submit" class="btn btn-success clock-btn">
                <i class="bi bi-box-arrow-in-right"></i> Clock In
            </button>
        </form>
    @else
        <div class="mb-3">
            <span class="status-badge bg-success">
                Clocked in at {{ \Carbon\Carbon::parse($latestRecord->timeIn)->format('h:i A') }}
            </span>
        </div>
        <form action="{{ route('attendance.clock') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="action" value="clock_out">
            <input type="hidden" name="recordID" value="{{ $latestRecord->recordID }}">
            <button type="submit" class="btn btn-danger clock-btn">
                <i class="bi bi-box-arrow-right"></i> Clock Out
            </button>
        </form>
    @endif
</div>