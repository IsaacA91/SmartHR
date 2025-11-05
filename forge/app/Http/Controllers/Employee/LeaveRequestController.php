<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $employee = Auth::guard('employee')->user();
        $leaveRequests = LeaveRequest::where('employeeID', $employee->employeeID)
            ->orderBy('startDate', 'desc')
            ->paginate(10);

        return view('leave.index', compact('leaveRequests'));
    }

    public function create()
    {
        return view('leave.create');
    }

    public function store(Request $request)
    {
        // Log incoming request so we can see if the form submission reaches the controller
        Log::info('LeaveRequestController@store called', ['input' => $request->all(), 'ip' => $request->ip(), 'user' => Auth::guard('employee')->id()]);

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        try {
            // Generate next leaveRecordID (L0001, L0002, etc.)
            $newId = 'L0001';  // Default for first record

            $last = LeaveRequest::orderBy('leaveRecordID', 'desc')->value('leaveRecordID');
            if ($last && preg_match('/L(\d+)$/', $last, $m)) {
                $nextNum = intval($m[1]) + 1;
                $newId = 'L' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
            }

            // Log ID generation for debugging
            Log::info('Generated new leaveRecordID', ['newId' => $newId, 'lastId' => $last]);

            $leaveRequest = new LeaveRequest();
            $leaveRequest->leaveRecordID = $newId;
            $leaveRequest->employeeID = Auth::guard('employee')->user()->employeeID;
            $leaveRequest->startDate = $request->start_date;
            $leaveRequest->endDate = $request->end_date;
            // approval will default to 'Pending' from the model's $attributes
            $leaveRequest->save();

            Log::info('LeaveRequest created successfully', [
                'employeeID' => Auth::guard('employee')->user()->employeeID,
                'leaveRecordID' => $newId
            ]);

            return redirect()
                ->route('leave.index')
                ->with('success', 'Leave request submitted successfully.');
        } catch (\Exception $e) {
            // Log exception so we can debug why creation failed
            Log::error('Error submitting leave request', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString(), 'input' => $request->all()]);

            return back()
                ->with('error', 'Error submitting leave request: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(LeaveRequest $leaveRequest)
    {
        // Ensure the employee can only view their own leave requests
        if ($leaveRequest->employeeID !== Auth::guard('employee')->user()->employeeID) {
            abort(403);
        }

        return view('leave.show', compact('leaveRequest'));
    }

    public function cancel(LeaveRequest $leaveRequest)
    {
        // Ensure the employee can only cancel their own pending leave requests
        if ($leaveRequest->employeeID !== Auth::guard('employee')->user()->employeeID ||
                $leaveRequest->status !== 'pending') {
            abort(403);
        }

        try {
            $leaveRequest->update(['status' => 'cancelled']);
            return redirect()
                ->route('leave.index')
                ->with('success', 'Leave request cancelled successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error cancelling leave request: ' . $e->getMessage());
        }
    }
}
