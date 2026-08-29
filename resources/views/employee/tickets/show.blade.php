@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.tickets.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Tickets</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-chat-left-text text-primary"></i> Communication Thread</h5>
            </div>
            <div class="card-body">
                
                <!-- Original Message -->
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="bg-light p-3 rounded text-dark shadow-sm">
                            <div class="fw-bold fs-5 mb-1">{{ $ticket->subject }}</div>
                            <div class="text-muted small mb-3">You opened this ticket on {{ $ticket->created_at->format('M d, Y h:i A') }}</div>
                            <div style="white-space: pre-line;">{{ $ticket->description }}</div>
                        </div>
                    </div>
                </div>

                <!-- Discussion Thread -->
                @foreach($ticket->replies as $reply)
                    <div class="d-flex mb-4 {{ $reply->user_id == Auth::id() ? 'flex-row-reverse' : '' }}">
                        <div class="flex-shrink-0 {{ $reply->user_id == Auth::id() ? 'ms-3' : 'me-3' }}">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; background-color: {{ $reply->user_id == Auth::id() ? '#0d6efd' : '#475569' }};">
                                <i class="bi {{ $reply->user_id == Auth::id() ? 'bi-person' : 'bi-headset' }}"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="p-3 rounded shadow-sm {{ $reply->user_id == Auth::id() ? 'bg-primary text-white text-end' : 'bg-white border' }}">
                                <div class="small fw-bold mb-1 {{ $reply->user_id == Auth::id() ? 'text-white-50' : 'text-muted' }}">
                                    {{ $reply->user->name }} • {{ $reply->created_at->diffForHumans() }}
                                </div>
                                <div style="white-space: pre-line;">{{ $reply->message }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Reply Form -->
                @if(in_array($ticket->status, ['Open', 'In Progress']))
                    <div class="mt-4 border-top pt-4">
                        <form action="{{ route('employee.tickets.reply', $ticket) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="message" rows="3" class="form-control shadow-sm" placeholder="Type your reply here..." required></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary shadow-sm"><i class="bi bi-reply"></i> Send Reply</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="alert alert-secondary text-center mt-4 border-0">
                        <i class="bi bi-lock-fill"></i> This ticket has been marked as {{ $ticket->status }}. It is locked for new replies.
                    </div>
                @endif
                
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-4 border-bottom pb-2">Ticket Metadata</h6>
                
                <div class="mb-3">
                    <span class="text-muted d-block small">Status</span>
                    @php
                        $sBadge = match($ticket->status) {
                            'Open' => 'text-danger',
                            'In Progress' => 'text-info',
                            'Resolved', 'Closed' => 'text-success',
                            default => 'text-secondary'
                        };
                    @endphp
                    <span class="fw-bold {{ $sBadge }} fs-5">{{ $ticket->status }}</span>
                </div>
                
                <div class="mb-3">
                    <span class="text-muted d-block small">Priority</span>
                    <span class="fw-bold">{{ $ticket->priority }}</span>
                </div>
                
                <div class="mb-3">
                    <span class="text-muted d-block small">Department Category</span>
                    <span class="fw-bold">{{ $ticket->category }}</span>
                </div>
                
                <div class="mb-3">
                    <span class="text-muted d-block small">Tracking ID</span>
                    <span class="font-monospace">TCK-{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
