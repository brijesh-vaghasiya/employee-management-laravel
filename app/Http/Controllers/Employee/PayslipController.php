<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payslip;
use Illuminate\Support\Facades\Auth;

class PayslipController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            abort(403, 'Employee profile not linked.');
        }

        $payslips = Payslip::where('employee_id', $employee->id)->latest('salary_month')->paginate(12);
        return view('employee.payslips.index', compact('payslips'));
    }

    public function show(Payslip $payslip)
    {
        $employee = Auth::user()->employee;
        if (!$employee || $payslip->employee_id !== $employee->id) {
            abort(403, 'Unauthorized access to payslip.');
        }

        return view('employee.payslips.show', compact('payslip'));
    }
}
