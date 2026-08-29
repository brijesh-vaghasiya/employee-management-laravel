<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseClaim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseClaimController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) return abort(403);

        $claims = ExpenseClaim::where('employee_id', $employee->id)->latest()->paginate(10);
        return view('employee.expense_claims.index', compact('claims'));
    }

    public function create()
    {
        return view('employee.expense_claims.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0.1',
            'description' => 'required|string',
            'receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('expense_receipts', 'public');
        }

        ExpenseClaim::create([
            'employee_id' => Auth::user()->employee->id,
            'expense_date' => $request->expense_date,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'receipt_path' => $path,
            'status' => 'Pending',
        ]);

        return redirect()->route('employee.expense_claims.index')->with('success', 'Expense Claim Submitted Successfully!');
    }

    public function show(ExpenseClaim $expense_claim)
    {
        if ($expense_claim->employee_id !== Auth::user()->employee->id) abort(403);
        return view('employee.expense_claims.show', compact('expense_claim'));
    }

    public function destroy(ExpenseClaim $expense_claim)
    {
        if ($expense_claim->employee_id !== Auth::user()->employee->id) abort(403);
        if ($expense_claim->status !== 'Pending') {
            return redirect()->back()->with('error', 'Only pending claims can be deleted.');
        }

        if ($expense_claim->receipt_path) {
            Storage::disk('public')->delete($expense_claim->receipt_path);
        }

        $expense_claim->delete();
        return redirect()->back()->with('success', 'Claim Deleted.');
    }
}
