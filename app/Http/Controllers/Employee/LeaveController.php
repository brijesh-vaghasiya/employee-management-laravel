<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return redirect()->route('employee.dashboard')->with('error', 'Employee profile required.');
        }

        $leaves = Leave::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('employee.leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('employee.leaves.create');
    }

    public function store(Request $request)
    {
        $employee = Auth::user()->employee;
        
        $validated = $request->validate([
            'leave_type' => 'required|string|max:50',
            'reason' => 'required|string|max:1000',
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $fromDate = Carbon::parse($validated['from_date']);
        $toDate = Carbon::parse($validated['to_date']);
        $totalDays = $fromDate->diffInDays($toDate) + 1;

        Leave::create([
            'employee_id' => $employee->id,
            'leave_type' => $validated['leave_type'],
            'reason' => $validated['reason'],
            'from_date' => $validated['from_date'],
            'to_date' => $validated['to_date'],
            'total_days' => $totalDays,
            'status' => 'Pending',
        ]);

        return redirect()->route('employee.leaves.index')->with('success', 'Leave application submitted successfully.');
    }
}
