@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.tickets.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-headset text-primary"></i> Support Console: #{{ $ticket->id }}</h5>
            </div>
            <div class="card-body">
                
                <!-- Original Message -->
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="bg-light p-3 rounded text-dark shadow-sm">
                            <div class="fw-bold fs-5 mb-1">{{ $ticket->subject }}</div>
                            <div class="text-muted small mb-3">Reported by {{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }} on {{ $ticket->created_at->format('M d, Y h:i A') }}</div>
                            <div style="white-space: pre-line;">{{ $ticket->description }}</div>
                        </div>
                    </div>
                </div>

                <!-- Discussion Thread -->
                @foreach($ticket->replies as $reply)
                    <div class="d-flex mb-4 {{ $reply->user_id == Auth::id() ? 'flex-row-reverse' : '' }}">
                        <div class="flex-shrink-0 {{ $reply->user_id == Auth::id() ? 'ms-3' : 'me-3' }}">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 40px; height: 40px; background-color: {{ $reply->user_id == Auth::id() ? '#0d6efd' : '#475569' }};">
                                <i class="bi {{ $reply->user_id == Auth::id() ? 'bi-shield-check' : 'bi-person' }}"></i>
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
                <div class="mt-4 border-top pt-4">
                    <form action="{{ route('admin.tickets.reply', $ticket) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="message" rows="3" class="form-control shadow-sm" placeholder="Provide resolution updates..." required></textarea>
                            <div class="form-text">Replying as Admin will automatically mark an Open ticket as "In Progress".</div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="bi bi-reply"></i> Submit Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Update Status -->
        <div class="card shadow-sm border-0 mb-4 border-top border-4 border-primary">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2">Status Management</h6>
                <form action="{{ route('admin.tickets.updateStatus', $ticket) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="d-flex align-items-center">
                        <select name="status" class="form-select me-2 shadow-sm" required>
                            <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="In Progress" {{ $ticket->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Resolved" {{ $ticket->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        <button type="submit" class="btn btn-success shadow-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-4 border-bottom pb-2">Contextual Data</h6>
                
                <div class="mb-3">
                    <span class="text-muted d-block small">Priority</span>
                    @php
                        $pBadge = match($ticket->priority) {
                            'High', 'Critical' => 'bg-danger text-light px-2 py-1',
                            'Medium' => 'bg-warning text-dark px-2 py-1',
                            default => 'bg-success text-light px-2 py-1'
                        };
                    @endphp
                    <span class="badge {{ $pBadge }} fs-6">{{ $ticket->priority }}</span>
                </div>
                
                <div class="mb-3">
                    <span class="text-muted d-block small">Department Category</span>
                    <span class="fw-bold"><i class="bi bi-tag"></i> {{ $ticket->category }}</span>
                </div>
                
                <div class="mb-3">
                    <span class="text-muted d-block small">Requester Code</span>
                    <span class="font-monospace text-primary border border-primary px-1">{{ $ticket->employee->employee_code }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
