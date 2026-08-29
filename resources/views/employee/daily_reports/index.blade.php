@extends('layouts.employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Daily Work Reports</h2>
        <p class="text-muted small">Log your daily tasks and future plans here.</p>
    </div>
    <a href="{{ route('employee.daily_reports.create') }}" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Submit Today's Log</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Report Date</th>
                        <th>Brief Summary</th>
                        <th>Verification Strategy</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td class="ps-4 fw-bold">
                            <a href="{{ route('employee.daily_reports.show', $report) }}" class="text-decoration-none">
                                <i class="bi bi-calendar-event me-2"></i>{{ $report->date->format('l, F j, Y') }}
                            </a>
                        </td>
                        <td class="text-muted">{{ Str::limit($report->completed_tasks, 50) }}</td>
                        <td>
                            @if($report->status == 'Verified')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success"><i class="bi bi-check-circle-fill"></i> Read & Verified</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning text-dark border border-warning"><i class="bi bi-clock"></i> Pending Review</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('employee.daily_reports.show', $report) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-text"></i> View Log</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted">You haven't submitted any daily reports recently.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($reports->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $reports->links() }}
    </div>
    @endif
</div>
@endsection
