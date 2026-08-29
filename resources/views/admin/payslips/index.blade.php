@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Payroll Management</h2>
    <a href="{{ route('admin.payslips.create') }}" class="btn btn-primary"><i class="bi bi-receipt"></i> Generate Payslip</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Employee</th>
                        <th>Month</th>
                        <th>Net Pay</th>
                        <th>Status</th>
                        <th>Generated On</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payslips as $payslip)
                    <tr>
                        <td class="ps-3 fw-bold">
                            {{ $payslip->employee->first_name }} {{ $payslip->employee->last_name }}
                            <div class="text-muted small">{{ $payslip->employee->employee_code }}</div>
                        </td>
                        <td>{{ $payslip->salary_month }}</td>
                        <td class="fw-bold text-success">${{ number_format($payslip->net_pay, 2) }}</td>
                        <td>
                            <span class="badge {{ $payslip->status == 'Paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $payslip->status }}
                            </span>
                        </td>
                        <td>{{ $payslip->created_at->format('M d, Y') }}</td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.payslips.show', $payslip) }}" class="btn btn-sm btn-outline-info" title="View Payslip"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('admin.payslips.destroy', $payslip) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this payslip?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No payslips generated yet.</td></tr>
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
