<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseClaim;

class ExpenseClaimController extends Controller
{
    public function index()
    {
        $claims = ExpenseClaim::with('employee')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.expense_claims.index', compact('claims'));
    }

    public function show(ExpenseClaim $expense_claim)
    {
        return view('admin.expense_claims.show', compact('expense_claim'));
    }

    public function updateStatus(Request $request, ExpenseClaim $expense_claim)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected,Paid',
            'admin_remarks' => 'nullable|string',
        ]);

        $expense_claim->update([
            'status' => $request->status,
            'admin_remarks' => $request->admin_remarks,
        ]);

        return redirect()->back()->with('success', 'Expense Claim status updated successfully.');
    }

    public function destroy(ExpenseClaim $expense_claim)
    {
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($expense_claim->receipt_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($expense_claim->receipt_path);
        }
        $expense_claim->delete();
        return redirect()->back()->with('success', 'Claim record purged.');
    }
}
