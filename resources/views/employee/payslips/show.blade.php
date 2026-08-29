@extends('layouts.employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
    <div>
        <a href="{{ route('employee.payslips.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to My Payslips</a>
        <h2 class="mt-2">Payslip: {{ date('F Y', strtotime($payslip->salary_month)) }}</h2>
    </div>
    <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print / Save PDF</button>
</div>

<div class="card shadow-sm border-0 payslip-print">
    <div class="card-body p-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-1">COMPANY NAME LTD.</h2>
            <p class="text-muted mb-0">123 Corporate Tower, Business Hub, City 40001</p>
            <h4 class="mt-4 mb-0 text-decoration-underline">Payslip for the month of {{ date('F Y', strtotime($payslip->salary_month)) }}</h4>
        </div>

        <div class="row mb-5">
            <div class="col-md-6 text-start">
                <table class="table table-borderless table-sm">
                    <tr><td width="30%" class="text-muted">Employee Name</td><td class="fw-bold">: {{ $payslip->employee->first_name }} {{ $payslip->employee->last_name }}</td></tr>
                    <tr><td class="text-muted">Employee Code</td><td class="fw-bold">: {{ $payslip->employee->employee_code }}</td></tr>
                    <tr><td class="text-muted">Department</td><td class="fw-bold">: {{ $payslip->employee->department ?? 'N/A' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6 text-end">
                <table class="table table-borderless table-sm text-end">
                    <tr><td width="70%" class="text-muted">Payslip ID</td><td class="fw-bold">: #PSL-{{ str_pad($payslip->id, 5, '0', STR_PAD_LEFT) }}</td></tr>
                    <tr><td class="text-muted">Payment Date</td><td class="fw-bold">: {{ $payslip->payment_date ? $payslip->payment_date->format('d M, Y') : 'N/A' }}</td></tr>
                    <tr><td class="text-muted">Status</td><td class="fw-bold">: {{ $payslip->status }}</td></tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 mb-3 shadow-none bg-light">
                    <div class="card-header bg-success text-white"><strong>Earnings</strong></div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <span>Basic Salary</span><span>${{ number_format($payslip->basic_salary, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <span>House Rent Allowance</span><span>${{ number_format($payslip->house_rent_allowance, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <span>Conveyance Allowance</span><span>${{ number_format($payslip->conveyance_allowance, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <span>Medical Allowance</span><span>${{ number_format($payslip->medical_allowance, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <span>Special Allowance</span><span>${{ number_format($payslip->special_allowance, 2) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-0 mb-3 shadow-none bg-light">
                    <div class="card-header bg-danger text-white"><strong>Deductions</strong></div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <span>Provident Fund</span><span>${{ number_format($payslip->provident_fund, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <span>Tax Deduction</span><span>${{ number_format($payslip->tax_deduction, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <span>Other Deductions</span><span>${{ number_format($payslip->other_deductions, 2) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row mt-4 mb-5">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded text-success fw-bold d-flex justify-content-between border">
                    <span>Total Earnings:</span>
                    <span>${{ number_format($payslip->basic_salary + $payslip->house_rent_allowance + $payslip->conveyance_allowance + $payslip->medical_allowance + $payslip->special_allowance, 2) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded text-danger fw-bold d-flex justify-content-between border">
                    <span>Total Deductions:</span>
                    <span>${{ number_format($payslip->provident_fund + $payslip->tax_deduction + $payslip->other_deductions, 2) }}</span>
                </div>
            </div>
            <div class="col-md-12 mt-4 text-end">
                <div class="p-4 bg-primary text-white rounded shadow-sm d-inline-block">
                    <h3 class="mb-0">Net Pay: ${{ number_format($payslip->net_pay, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="mt-5 pt-5 text-center text-muted border-top">
            <p class="mb-0 small">This is a system generated document and does not require a signature.</p>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .payslip-print, .payslip-print * { visibility: visible; }
    .payslip-print { position: absolute; left: 0; top: 0; width: 100%; }
    .bg-light { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; }
    .bg-primary { background-color: #0d6efd !important; color: white !important; -webkit-print-color-adjust: exact; }
    .bg-success { background-color: #198754 !important; color: white !important; -webkit-print-color-adjust: exact; }
    .bg-danger { background-color: #dc3545 !important; color: white !important; -webkit-print-color-adjust: exact; }
}
</style>
@endsection
