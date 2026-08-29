@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Helpdesk Tickets</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3 w-25">Ticket Details</th>
                        <th class="w-15">Employee</th>
                        <th class="w-25">Description</th>
                        <th class="w-15">Date</th>
                        <th class="text-end pe-3 w-20">Status & Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td class="ps-3">
                            <span class="fw-bold d-block">{{ $req->requestOption->name ?? 'Unknown Category' }}</span>
                            <span class="small text-muted">Ticket #{{ str_pad($req->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            @if($req->employee)
                            <div class="fw-bold">{{ $req->employee->first_name }} {{ $req->employee->last_name }}</div>
                            @else
                            <span class="text-danger">Deleted User</span>
                            @endif
                        </td>
                        <td>
                            <p class="mb-0 small text-truncate" style="max-width: 250px;" title="{{ $req->description }}">
                                {{ $req->description }}
                            </p>
                        </td>
                        <td>{{ $req->created_at->format('M d, Y') }}</td>
                        <td class="text-end pe-3">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                @if($req->status == 'Pending')
                                    <span class="badge bg-warning text-dark me-2">Pending</span>
                                    
                                    <form action="{{ route('admin.employee_requests.update', $req->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Approve"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <form action="{{ route('admin.employee_requests.update', $req->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Reject"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                @elseif($req->status == 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                                
                                <form action="{{ route('admin.employee_requests.destroy', $req->id) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Delete this ticket entirely?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border" title="Delete"><i class="bi bi-trash text-danger"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">No tickets found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($requests->hasPages())
    <div class="card-footer bg-white border-0 pt-3">
        {{ $requests->links() }}
    </div>
    @endif
</div>
@endsection
