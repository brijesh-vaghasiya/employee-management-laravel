@extends('layouts.employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>IT & Support Tickets</h2>
        <p class="text-muted small">Raise issues with Human Resources, IT, or Facilities.</p>
    </div>
    <a href="{{ route('employee.tickets.create') }}" class="btn btn-primary"><i class="bi bi-headset"></i> Open New Ticket</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Ticket Subject</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td class="ps-4 fw-bold">
                            <a href="{{ route('employee.tickets.show', $ticket) }}" class="text-decoration-none">
                                #{{ $ticket->id }} - {{ Str::limit($ticket->subject, 40) }}
                            </a>
                        </td>
                        <td><span class="badge bg-light text-dark border border-secondary">{{ $ticket->category }}</span></td>
                        <td>
                            @php
                                $pBadge = match($ticket->priority) {
                                    'High' => 'text-danger fw-bold',
                                    'Critical' => 'text-danger fw-bold text-uppercase',
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
                        <td class="text-muted small">{{ $ticket->created_at->format('M d, Y') }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('employee.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary shadow-sm"><i class="bi bi-chat-text"></i> View Thread</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">You have no open support tickets.</td></tr>
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
