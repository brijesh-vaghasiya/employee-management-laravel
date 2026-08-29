@extends('layouts.employee')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h2>My Leaves</h2>
    <a href="{{ route('employee.leaves.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Apply for Leave</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Leave Type</th>
                        <th>Duration</th>
                        <th>Days</th>
                        <th>Status</th>
                        <th>Applied On</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                    <tr>
                        <td class="fw-bold">{{ $leave->leave_type }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($leave->from_date)->format('M d, Y') }} 
                            <span class="text-muted mx-1">to</span> 
                            {{ \Carbon\Carbon::parse($leave->to_date)->format('M d, Y') }}
                        </td>
                        <td>{{ $leave->total_days }}</td>
                        <td>
                            @if($leave->status == 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($leave->status == 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>{{ $leave->created_at->format('M d, Y') }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="popover" data-bs-trigger="focus" title="Reason" data-bs-content="{{ $leave->reason }}">
                                <i class="bi bi-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No leave records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $leaves->links() }}
        </div>
    </div>
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
