@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.expense_claims.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to My Claims</a>
    <h2 class="mt-2">Claim Details</h2>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary">Expense Submission</h5>
                
                @php
                    $badge = match($expense_claim->status) {
                        'Approved' => 'bg-success',
                        'Paid' => 'bg-info text-dark',
                        'Rejected' => 'bg-danger',
                        default => 'bg-warning text-dark'
                    };
                @endphp
                <span class="badge {{ $badge }} fs-6">{{ $expense_claim->status }}</span>
            </div>
            <div class="card-body p-4">
                
                @if($expense_claim->admin_remarks)
                <div class="alert {{ $expense_claim->status == 'Rejected' ? 'alert-danger' : 'alert-info' }} d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-chat-square-text fs-4 me-3"></i>
                    <div>
                        <strong>Admin Feedback:</strong><br>
                        {{ $expense_claim->admin_remarks }}
                    </div>
                </div>
                @endif
                
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
                    <div class="col-md-8 fw-bold fs-5 text-dark">${{ number_format($expense_claim->amount, 2) }}</div>
                </div>
                <div class="row mb-3 border-bottom pb-3">
                    <div class="col-md-4 text-muted">Description</div>
                    <div class="col-md-8">{{ $expense_claim->description }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Submitted On</div>
                    <div class="col-md-8">{{ $expense_claim->created_at->format('F j, Y, g:i A') }}</div>
                </div>
                
                @if($expense_claim->receipt_path)
                <div class="mt-5 border-top pt-4">
                    <h6 class="text-secondary fw-bold mb-3"><i class="bi bi-paperclip"></i> Attached Receipt</h6>
                    @if(Str::endsWith(strtolower($expense_claim->receipt_path), ['.jpg', '.jpeg', '.png']))
                        <a href="{{ Storage::url($expense_claim->receipt_path) }}" target="_blank">
                            <img src="{{ Storage::url($expense_claim->receipt_path) }}" class="img-fluid rounded border p-1" style="max-height: 250px;" alt="Receipt">
                        </a>
                        <div class="mt-2 text-muted small"><i class="bi bi-info-circle"></i> Click to enlarge</div>
                    @else
                        <a href="{{ Storage::url($expense_claim->receipt_path) }}" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-file-earmark-pdf"></i> Open PDF Attachment</a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
