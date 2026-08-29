<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeRequest;
use App\Models\RequestOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) return redirect()->route('employee.dashboard')->with('error', 'Profile not linked.');
        $employeeId = $employee->id;
        $requests = EmployeeRequest::with('requestOption')
            ->where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $options = RequestOption::orderBy('name')->get();
            
        return view('employee.requests.index', compact('requests', 'options'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_option_id' => 'required|exists:request_options,id',
            'description' => 'required|string',
        ]);

        $employee = Auth::user()->employee;
        if (!$employee) return back()->with('error', 'Profile not linked.');
        $validated['employee_id'] = $employee->id;
        
        EmployeeRequest::create($validated);
        
        return redirect()->back()->with('success', 'Your request has been submitted successfully.');
    }
}
