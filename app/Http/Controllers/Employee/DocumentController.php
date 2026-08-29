<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return redirect()->route('employee.dashboard')->with('error', 'Profile not found.');
        }

        $myDocuments = EmployeeDocument::with('document')
            ->where('employee_id', $employee->id)
            ->orderBy('assigned_date', 'desc')
            ->paginate(15);
            
        return view('employee.documents.index', compact('myDocuments'));
    }
}
