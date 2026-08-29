@extends('layouts.employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Helpdesk Tickets</h2>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold">
                Submit a Request
            </div>
            <div class="card-body">
                <form action="{{ route('employee.requests.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Request Type</label>
                        <select name="request_option_id" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            @foreach($options as $option)
                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description / Issue Log</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Briefly describe what you need..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit Ticket</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Request Details</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold d-block">{{ $req->requestOption->name ?? 'Unknown Category' }}</span>
                                <span class="small text-muted">{{ Str::limit($req->description, 60) }}</span>
                            </td>
                            <td>
                                @if($req->status == 'Pending')
                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock"></i> Pending</span>
                                @elseif($req->status == 'Approved')
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Approved</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Rejected</span>
                                @endif
                            </td>
                            <td>{{ $req->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-4 text-muted">You have no ticket history.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($requests->hasPages())
            <div class="card-footer bg-white border-0 pt-3">
                {{ $requests->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
