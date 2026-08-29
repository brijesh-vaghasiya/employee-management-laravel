@extends('layouts.employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Expense Claims</h2>
    <a href="{{ route('employee.expense_claims.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Submit New Claim</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Date & Category</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($claims as $claim)
                    <tr>
                        <td class="ps-3">
                            <div class="fw-bold">{{ $claim->category }}</div>
                            <div class="text-muted small">{{ $claim->expense_date->format('M d, Y') }}</div>
                        </td>
                        <td class="fw-bold text-dark">${{ number_format($claim->amount, 2) }}</td>
                        <td class="text-muted">{{ Str::limit($claim->description, 30) }}</td>
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
                            <a href="{{ route('employee.expense_claims.show', $claim) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> View</a>
                            @if($claim->status === 'Pending')
                                <form action="{{ route('employee.expense_claims.destroy', $claim) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this pending claim submission?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i> Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">You haven't submitted any expense claims yet.</td></tr>
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
