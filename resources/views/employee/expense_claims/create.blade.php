@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.expense_claims.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to My Claims</a>
    <h2 class="mt-2">Submit New Expense Claim</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('employee.expense_claims.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expense Date <span class="text-danger">*</span></label>
                            <input type="date" name="expense_date" class="form-control @error('expense_date') is-invalid @enderror" value="{{ old('expense_date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            @error('expense_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="">Select Category...</option>
                                <option value="Travel" {{ old('category') == 'Travel' ? 'selected' : '' }}>Travel & Transport</option>
                                <option value="Food & Dining" {{ old('category') == 'Food & Dining' ? 'selected' : '' }}>Food & Dining</option>
                                <option value="Accommodation" {{ old('category') == 'Accommodation' ? 'selected' : '' }}>Accommodation / Hotel</option>
                                <option value="Office Supplies" {{ old('category') == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
                                <option value="Client Entertainment" {{ old('category') == 'Client Entertainment' ? 'selected' : '' }}>Client Entertainment</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other Business Expense</option>
                            </select>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Amount Requested <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" placeholder="0.00" required>
                        </div>
                        @error('amount')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Description / Business Purpose <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Briefly explain the purpose of this expense..." required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Upload Receipt (Optional but recommended)</label>
                        <input type="file" name="receipt" class="form-control @error('receipt') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                        <div class="form-text">Accepted formats: JPG, PNG, PDF. Max size: 2MB.</div>
                        @error('receipt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary px-5"><i class="bi bi-send"></i> Submit Claim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 bg-light shadow-sm">
            <div class="card-body p-4">
                <h5><i class="bi bi-info-circle text-primary"></i> Claim Guidelines</h5>
                <p class="text-muted small mt-3">Please adhere to the company reimbursement policies before submitting claims:</p>
                <ul class="text-muted small">
                    <li class="mb-2">Receipts are mandatory for amounts exceeding $50.00.</li>
                    <li class="mb-2">Ensure dates accurately match your attached receipts.</li>
                    <li class="mb-2">Client entertainment must specify the client name in the description.</li>
                    <li>False claims are subject to immediate administrative review.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
