@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.expense_claims.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Claims</a>
    <h2 class="mt-2">Review Expense Claim</h2>
</div>

<div class="row">
    <div class="col-md-7 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary">Claim Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3 border-bottom pb-3">
                    <div class="col-md-4 text-muted">Employee</div>
                    <div class="col-md-8 fw-bold">{{ $expense_claim->employee->first_name }} {{ $expense_claim->employee->last_name }} ({{ $expense_claim->employee->employee_code }})</div>
                </div>
                <div class="row mb-3 border-bottom pb-3">
                    <div class="col-md-4 text-muted">Date of Expense</div>
                    <div class="col-md-8 fw-bold">{{ $expense_claim->expense_date->format('l, F j, Y') }}</div>
                </div>
                <div class="row mb-3 border-bottom pb-3">
                    <div class="col-md-4 text-muted">Category</div>
                    <div class="col-md-8 fw-bold">{{ $expense_claim->category }}</div>
                </div>
                <div class="row mb-3 border-bottom pb-3">
                    <div class="col-md-4 text-muted">Amount Requested</div>
                    <div class="col-md-8 fw-bold fs-5 text-success">${{ number_format($expense_claim->amount, 2) }}</div>
                </div>
                <div class="row mb-3 border-bottom pb-3">
                    <div class="col-md-4 text-muted">Description</div>
                    <div class="col-md-8">{{ $expense_claim->description }}</div>
                </div>
                
                @if($expense_claim->receipt_path)
                <div class="mt-4">
                    <h6 class="text-primary mb-3">Attached Receipt/Proof</h6>
                    @if(Str::endsWith(strtolower($expense_claim->receipt_path), ['.jpg', '.jpeg', '.png']))
                        <a href="{{ Storage::url($expense_claim->receipt_path) }}" target="_blank">
                            <img src="{{ Storage::url($expense_claim->receipt_path) }}" class="img-fluid rounded border p-1" style="max-height: 250px;" alt="Receipt">
                        </a>
                    @else
                        <a href="{{ Storage::url($expense_claim->receipt_path) }}" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-file-earmark-pdf"></i> View Attachment</a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm border-0 border-top border-4 border-warning">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-dark">Action Center</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Current Status</h6>
                    @php
                        $badge = match($expense_claim->status) {
                            'Approved' => 'bg-success fs-5',
                            'Paid' => 'bg-info text-dark fs-5',
                            'Rejected' => 'bg-danger fs-5',
                            default => 'bg-warning text-dark fs-5'
                        };
                    @endphp
                    <span class="badge {{ $badge }}">{{ $expense_claim->status }}</span>
                    
                    @if($expense_claim->admin_remarks)
                        <div class="mt-3 p-3 bg-light rounded text-muted fst-italic">
                            <strong>Previous Remarks:</strong> {{ $expense_claim->admin_remarks }}
                        </div>
                    @endif
                </div>
                
                <hr>
                
                <form action="{{ route('admin.expense_claims.updateStatus', $expense_claim) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Update Status to:</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="Approved" {{ $expense_claim->status == 'Approved' ? 'selected' : '' }}>Approve Claim</option>
                            <option value="Paid" {{ $expense_claim->status == 'Paid' ? 'selected' : '' }}>Mark as Paid</option>
                            <option value="Rejected" {{ $expense_claim->status == 'Rejected' ? 'selected' : '' }}>Reject Claim</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Admin Remarks <small class="text-muted">(Optional)</small></label>
                        <textarea name="admin_remarks" class="form-control" rows="3" placeholder="Reason for rejection, payment reference, etc.">{{ old('admin_remarks', $expense_claim->admin_remarks) }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Save Action</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
