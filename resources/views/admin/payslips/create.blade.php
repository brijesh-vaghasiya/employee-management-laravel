@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.payslips.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Payroll</a>
    <h2 class="mt-2">Generate Payslip</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.payslips.store') }}" method="POST">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Employee <span class="text-danger">*</span></label>
                    <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->employee_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label class="form-label">Salary Month <span class="text-danger">*</span></label>
                    <input type="month" name="salary_month" class="form-control @error('salary_month') is-invalid @enderror" value="{{ old('salary_month', \Carbon\Carbon::now()->subMonth()->format('Y-m')) }}" required>
                    @error('salary_month')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date') }}">
                    @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <h5 class="mb-3 text-success border-bottom pb-2">Earnings</h5>
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Basic Salary <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="basic_salary" class="form-control @error('basic_salary') is-invalid @enderror" value="{{ old('basic_salary', 0) }}" required>
                    </div>
                    @error('basic_salary')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">House Rent Allowance</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="house_rent_allowance" class="form-control" value="{{ old('house_rent_allowance', 0) }}">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Conveyance Allowance</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="conveyance_allowance" class="form-control" value="{{ old('conveyance_allowance', 0) }}">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Medical Allowance</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="medical_allowance" class="form-control" value="{{ old('medical_allowance', 0) }}">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Special Allowance</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="special_allowance" class="form-control" value="{{ old('special_allowance', 0) }}">
                    </div>
                </div>
            </div>

            <h5 class="mb-3 text-danger border-bottom pb-2">Deductions</h5>
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Provident Fund (PF)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="provident_fund" class="form-control" value="{{ old('provident_fund', 0) }}">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tax Deduction</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="tax_deduction" class="form-control" value="{{ old('tax_deduction', 0) }}">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Other Deductions</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="other_deductions" class="form-control" value="{{ old('other_deductions', 0) }}">
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary px-5"><i class="bi bi-calculator"></i> Calculate & Generate Payslip</button>
            </div>
        </form>
    </div>
</div>
@endsection
