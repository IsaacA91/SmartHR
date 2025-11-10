<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $companyID = Auth::guard('admin')->user()->companyID;
        
        $leaveRequests = LeaveRequest::whereIn('employeeID', function($query) use ($companyID) {
            $query->select('employeeID')
                  ->from('employee')
                  ->where('companyID', $companyID);
        })
        ->where('status', 'pending')
        ->orderBy('startDate', 'asc')
        ->with('employee') // Eager load employee relationship
        ->paginate(10);

        return view('admin.leave-requests.index', compact('leaveRequests'));
    }

    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'approval' => 'required|in:Approved,Rejected,Pending',
            'admin_remarks' => 'nullable|string|max:500'
        ]);

        $leaveRequest->update([
            'approval' => $request->approval,
            'admin_remarks' => $request->admin_remarks
        ]);

        return redirect()->back()->with('success', 'Leave request has been ' . $request->approval);
    }
}