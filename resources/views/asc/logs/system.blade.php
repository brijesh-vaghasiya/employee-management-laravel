@extends('layouts.asc')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-journal-text text-danger me-2"></i> System Audit Logs</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4 py-3 w-25">Action Invoked</th>
                        <th class="w-50">Log Description</th>
                        <th>User Ref</th>
                        <th class="text-end pe-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="ps-4 fw-bold text-danger">{{ $log->action }}</td>
                        <td class="small text-muted">{{ $log->description }}</td>
                        <td>
                            @if($log->user)
                                <span class="badge bg-info text-dark">UID: {{ $log->user->id }}</span>
                            @else
                                <span class="text-muted small">System</span>
                            @endif
                        </td>
                        <td class="text-end pe-4 text-muted small">
                            {{ $log->created_at->format('M d, Y h:i A') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted">No system activities recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($logs->hasPages())
    <div class="card-footer bg-white border-0 pt-3">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
