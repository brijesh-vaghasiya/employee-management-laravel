@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Support Tickets Dashboard</h2>
        <p class="text-muted small">Manage internal requests and IT support tickets.</p>
    </div>
    
    <form action="{{ route('admin.tickets.index') }}" method="GET" class="d-flex">
        <select name="status" class="form-select bg-light border-0 shadow-sm custom-select me-2" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
            <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
            <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
        </select>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Ticket</th>
                        <th>Requester</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-decoration-none fw-bold">
                                #{{ $ticket->id }} - {{ Str::limit($ticket->subject, 30) }}
                            </a>
                            <div class="text-muted small">{{ $ticket->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }}</div>
                            <div class="text-muted small">{{ $ticket->employee->designation }}</div>
                        </td>
                        <td><span class="badge border border-secondary text-secondary">{{ $ticket->category }}</span></td>
                        <td>
                            @php
                                $pBadge = match($ticket->priority) {
                                    'High', 'Critical' => 'text-danger fw-bold',
                                    'Medium' => 'text-warning text-dark',
                                    default => 'text-success'
                                };
                            @endphp
                            <span class="{{ $pBadge }}"><i class="bi bi-flag-fill"></i> {{ $ticket->priority }}</span>
                        </td>
                        <td>
                            @php
                                $sBadge = match($ticket->status) {
                                    'Open' => 'bg-danger',
                                    'In Progress' => 'bg-info text-dark',
                                    'Resolved', 'Closed' => 'bg-success',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $sBadge }}">{{ $ticket->status }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">No tickets found in the system.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($tickets->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $tickets->links() }}
    </div>
    @endif
</div>
@endsection
