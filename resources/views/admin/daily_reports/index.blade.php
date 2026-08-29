@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Company Wide EOD Reports</h2>
        <p class="text-muted small">Monitor daily productivity across the organization.</p>
    </div>
    
    <form action="{{ route('admin.daily_reports.index') }}" method="GET" class="d-flex bg-white p-2 rounded shadow-sm">
        <div class="input-group">
            <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-event"></i></span>
            <input type="date" name="date" class="form-control border-0 bg-light me-2" value="{{ $date }}" onchange="this.form.submit()">
            <button type="submit" class="btn btn-primary d-none">Filter</button>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        @if($date)
            <div class="bg-primary bg-opacity-10 px-4 py-3 border-bottom border-primary border-opacity-25 text-primary fw-bold">
                Showing reports for: {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Employee</th>
                        <th>Date</th>
                        <th>Summary</th>
                        <th>State</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">{{ $report->employee->first_name }} {{ $report->employee->last_name }}</div>
                            <div class="text-muted small">{{ $report->employee->department }}</div>
                        </td>
                        <td>{{ $report->date->format('M d, Y') }}</td>
                        <td class="text-muted">{{ Str::limit($report->completed_tasks, 45) }}</td>
                        <td>
                            @if($report->status == 'Verified')
                                <span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle"></i> Verified</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning text-dark"><i class="bi bi-clock"></i> Pending Review</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.daily_reports.show', $report) }}" class="btn btn-sm {{ $report->status == 'Verified' ? 'btn-outline-secondary' : 'btn-primary shadow-sm' }}">
                                {{ $report->status == 'Verified' ? 'View' : 'Review Now' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">No reports found for this specific timeline.</td></tr>
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
