<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payslip;
use App\Models\Employee;

class PayslipController extends Controller
{
    public function index()
    {
        $payslips = Payslip::with('employee')->latest('salary_month')->paginate(15);
        return view('admin.payslips.index', compact('payslips'));
    }

    public function create()
    {
        $employees = Employee::where('is_active', true)->get();
        return view('admin.payslips.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary_month' => 'required|string',
            'basic_salary' => 'required|numeric|min:0',
            'house_rent_allowance' => 'required|numeric|min:0',
            'conveyance_allowance' => 'required|numeric|min:0',
            'medical_allowance' => 'required|numeric|min:0',
            'special_allowance' => 'required|numeric|min:0',
            'provident_fund' => 'required|numeric|min:0',
            'tax_deduction' => 'required|numeric|min:0',
            'other_deductions' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
        ]);

        $earnings = $request->basic_salary + $request->house_rent_allowance + $request->conveyance_allowance + $request->medical_allowance + $request->special_allowance;
        $deductions = $request->provident_fund + $request->tax_deduction + $request->other_deductions;
        $net_pay = $earnings - $deductions;

        Payslip::create([
            'employee_id' => $request->employee_id,
            'salary_month' => $request->salary_month,
            'basic_salary' => $request->basic_salary,
            'house_rent_allowance' => $request->house_rent_allowance,
            'conveyance_allowance' => $request->conveyance_allowance,
            'medical_allowance' => $request->medical_allowance,
            'special_allowance' => $request->special_allowance,
            'provident_fund' => $request->provident_fund,
            'tax_deduction' => $request->tax_deduction,
            'other_deductions' => $request->other_deductions,
            'net_pay' => $net_pay,
            'payment_date' => $request->payment_date,
            'status' => 'Generated',
        ]);

        return redirect()->route('admin.payslips.index')->with('success', 'Payslip Generated Successfully!');
    }

    public function show(Payslip $payslip)
    {
        return view('admin.payslips.show', compact('payslip'));
    }

    public function destroy(Payslip $payslip)
    {
        $payslip->delete();
        return redirect()->back()->with('success', 'Payslip Deleted.');
    }
}
