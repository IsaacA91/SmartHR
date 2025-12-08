<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveRequestsController extends Controller
{
    public function index()
    {
        $companyID = Auth::guard('admin')->user()->companyID;

        // Using raw queries with explicit collation to avoid collation mismatch
        $leaveRequests = DB::table('leaverequests as l')
            ->join(DB::raw('(SELECT employeeID, firstName, lastName FROM employee WHERE companyID COLLATE utf8mb4_unicode_ci = ?) as e'), 
                function($join) {
                    $join->on('l.employeeID', '=', DB::raw('e.employeeID COLLATE utf8mb4_unicode_ci'));
                })
            ->where('l.status', 'pending')
            ->orderBy('l.startDate', 'asc')
            ->select('l.*', 'e.firstName', 'e.lastName')
            ->setBindings([$companyID])
            ->paginate(5);

        return view('admin.leave-requests.index', compact('leaveRequests'));
    }

    public function updateStatus(Request $request, $leaveRecordID)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string|max:500'
        ]);

        DB::table('leaverequests')
            ->where('leaveRecordID', $leaveRecordID)
            ->update([
                'status' => $request->status,
                'admin_remarks' => $request->admin_remarks,
                'approval' => $request->status
            ]);

        return redirect()->back()->with('success', 'Leave request has been ' . $request->status);
    }
}