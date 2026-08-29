@extends('layouts.asc')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-door-open text-primary me-2"></i> System Login Logs</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4 py-3">User Email</th>
                        <th>Assumed Role</th>
                        <th>Target Project</th>
                        <th>IP Address</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $log->email }}</td>
                        <td><span class="badge bg-secondary">{{ $log->role }}</span></td>
                        <td>{{ $log->project ?? 'N/A' }}</td>
                        <td class="font-monospace text-muted">{{ $log->ip_address }}</td>
                        <td>
                            @if($log->result == 'Success')
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Success</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Failed</span>
                            @endif
                        </td>
                        <td class="text-end pe-4 text-muted small">
                            {{ $log->login_date ? \Carbon\Carbon::parse($log->login_date)->format('M d, Y h:i A') : 'N/A' }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">No login activities recorded yet.</td></tr>
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
