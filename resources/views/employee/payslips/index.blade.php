@extends('layouts.employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Payslips</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Month</th>
                        <th>Net Pay</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payslips as $payslip)
                    <tr>
                        <td class="ps-3 fw-bold">{{ date('F Y', strtotime($payslip->salary_month)) }}</td>
                        <td class="fw-bold text-success">${{ number_format($payslip->net_pay, 2) }}</td>
                        <td>{{ $payslip->payment_date ? $payslip->payment_date->format('M d, Y') : 'Pending' }}</td>
                        <td>
                            <span class="badge {{ $payslip->status == 'Paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $payslip->status }}
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('employee.payslips.show', $payslip) }}" class="btn btn-sm btn-primary"><i class="bi bi-file-earmark-pdf"></i> View / Download</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">No payslips available yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payslips->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $payslips->links() }}
    </div>
    @endif
</div>
@endsection
