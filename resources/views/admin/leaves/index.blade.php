@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Leave Management</h2>
</div>

<div class="card shadow-sm mb-4 border-0">
    <div class="card-body bg-light rounded">
        <form action="{{ route('admin.leaves.index') }}" method="GET" class="row gx-3 gy-2 align-items-center">
            
            <div class="col-sm-3">
                <label class="visually-hidden" for="status">Filter by Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Statuses</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="col-sm-4">
                <label class="visually-hidden" for="employee_id">Filter by Employee</label>
                <select class="form-select" id="employee_id" name="employee_id">
                    <option value="">All Employees</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->employee_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.leaves.index') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Employee</th>
                        <th>Leave Type</th>
                        <th>Dates</th>
                        <th>Days</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                    <tr>
                        <td class="ps-3">
                            @if($leave->employee)
                                <div class="fw-bold">{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</div>
                                <div class="small text-muted">{{ $leave->employee->designation }}</div>
                            @else
                                <span class="text-danger">Deleted Employee</span>
                            @endif
                        </td>
                        <td class="fw-bold text-secondary">{{ $leave->leave_type }}</td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($leave->from_date)->format('M d, Y') }}</div>
                            <div class="small text-muted">to {{ \Carbon\Carbon::parse($leave->to_date)->format('M d, Y') }}</div>
                        </td>
                        <td>{{ $leave->total_days }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="popover" data-bs-trigger="focus" title="Reason for Leave" data-bs-content="{{ $leave->reason }}">
                                <i class="bi bi-chat-left-text"></i> View
                            </button>
                        </td>
                        <td>
                            @if($leave->status == 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($leave->status == 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($leave->status == 'Pending')
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.leaves.updateStatus', $leave->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" class="btn btn-sm btn-success" title="Approve"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <form action="{{ route('admin.leaves.updateStatus', $leave->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Reject"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                </div>
                            @else
                                <span class="small text-muted">
                                    Determined by {{ $leave->modified_by ?? 'Admin' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No leave applications found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($leaves->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $leaves->withQueryString()->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function(){
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    });
</script>
@endpush
@endsection
