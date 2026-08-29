@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Expense & Reimbursement Claims</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Employee</th>
                        <th>Date & Category</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($claims as $claim)
                    <tr>
                        <td class="ps-3 fw-bold">
                            {{ $claim->employee->first_name }} {{ $claim->employee->last_name }}
                            <div class="text-muted small">{{ $claim->employee->employee_code }}</div>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $claim->category }}</div>
                            <div class="text-muted small">{{ $claim->expense_date->format('M d, Y') }}</div>
                        </td>
                        <td class="fw-bold">${{ number_format($claim->amount, 2) }}</td>
                        <td>
                            @php
                                $badge = match($claim->status) {
                                    'Approved' => 'bg-success',
                                    'Paid' => 'bg-info text-dark',
                                    'Rejected' => 'bg-danger',
                                    default => 'bg-warning text-dark'
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ $claim->status }}</span>
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.expense_claims.show', $claim) }}" class="btn btn-sm btn-primary">Review</a>
                            <form action="{{ route('admin.expense_claims.destroy', $claim) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to completely purge this claim record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">No expense claims submitted yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($claims->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $claims->links() }}
    </div>
    @endif
</div>
@endsection
