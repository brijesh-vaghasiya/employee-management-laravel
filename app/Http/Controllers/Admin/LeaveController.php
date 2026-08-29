<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with('employee');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $leaves = $query->orderBy('created_at', 'desc')->paginate(15);
        $employees = Employee::orderBy('first_name')->get(['id', 'first_name', 'last_name', 'employee_code']);

        return view('admin.leaves.index', compact('leaves', 'employees'));
    }

    public function update(Request $request, Leave $leaf)
    {
        // Using $leaf instead of $leave because Laravel singularizes 'leaves' to 'leaf' in route model binding natively sometimes although customizable. 
        // We'll rely on the actual passed parameter which might be named 'leave'.
        // Let's use the actual ID to be safe if model binding fails due to pluralization quirks.
    }
    
    public function updateStatus(Request $request, $id)
    {
        $leave = Leave::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected,Pending'
        ]);

        $leave->update([
            'status' => $validated['status'],
            'modified_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Leave status updated successfully.');
    }
}
