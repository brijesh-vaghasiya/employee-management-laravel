<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDocument;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeDocumentController extends Controller
{
    public function index()
    {
        $employeeDocuments = EmployeeDocument::with(['employee', 'document'])->orderBy('assigned_date', 'desc')->paginate(15);
        return view('admin.employee_documents.index', compact('employeeDocuments'));
    }

    public function create()
    {
        $employees = Employee::where('is_active', true)->orderBy('first_name')->get();
        $documents = Document::orderBy('name')->get();
        return view('admin.employee_documents.create', compact('employees', 'documents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'document_id' => 'required|exists:documents,id',
            'assigned_date' => 'required|date'
        ]);

        // Prevent exact duplicate assignment
        $exists = EmployeeDocument::where('employee_id', $validated['employee_id'])
            ->where('document_id', $validated['document_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This document is already assigned to the selected employee.');
        }

        EmployeeDocument::create($validated);
        return redirect()->route('admin.employee_documents.index')->with('success', 'Document assigned to employee successfully.');
    }

    public function destroy($id)
    {
        $employeeDocument = EmployeeDocument::findOrFail($id);
        $employeeDocument->delete();
        return redirect()->route('admin.employee_documents.index')->with('success', 'Document assignment removed.');
    }
}
