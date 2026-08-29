<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeRequest;
use Illuminate\Http\Request;

class EmployeeRequestController extends Controller
{
    public function index()
    {
        $requests = EmployeeRequest::with(['employee', 'requestOption'])
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 1 ELSE 2 END")
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.employee_requests.index', compact('requests'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected'
        ]);

        $employeeRequest = EmployeeRequest::findOrFail($id);
        $employeeRequest->update(['status' => $validated['status']]);
        
        return redirect()->back()->with('success', 'Request status updated to ' . $validated['status']);
    }

    public function destroy($id)
    {
        $employeeRequest = EmployeeRequest::findOrFail($id);
        $employeeRequest->delete();
        return redirect()->back()->with('success', 'Request deleted from logs.');
    }
}
