@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.daily_reports.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to History</a>
</div>

<div class="card shadow-sm border-0 border-top border-4 {{ $dailyReport->status == 'Verified' ? 'border-success' : 'border-primary' }}">
    <div class="card-body p-5">
        <div class="d-flex justify-content-between align-items-start mb-4 border-bottom pb-4">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-journal-text text-primary me-2"></i> EOD Report</h4>
                <h5 class="text-muted">{{ $dailyReport->date->format('l, F j, Y') }}</h5>
            </div>
            <div>
                @if($dailyReport->status == 'Verified')
                    <span class="badge bg-success bg-opacity-10 text-success border border-success fs-6 py-2 px-3"><i class="bi bi-check-circle-fill"></i> Read & Verified by Admin</span>
                @else
                    <span class="badge bg-warning bg-opacity-10 text-warning text-dark border border-warning fs-6 py-2 px-3"><i class="bi bi-clock"></i> Pending Review</span>
                @endif
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 mb-4">
                <h6 class="text-primary fw-bold text-uppercase"><i class="bi bi-check-all"></i> Tasks Completed Today</h6>
                <div class="p-4 bg-light rounded text-dark fs-6" style="white-space: pre-line;">{{ $dailyReport->completed_tasks }}</div>
            </div>
            
            <div class="col-md-6 mb-4">
                <h6 class="text-secondary fw-bold text-uppercase"><i class="bi bi-arrow-return-right"></i> Plan for Tomorrow</h6>
                <div class="p-3 bg-light rounded text-dark border-start border-3 border-secondary" style="white-space: pre-line;">{{ $dailyReport->tomorrow_plan }}</div>
            </div>
            
            <div class="col-md-6 mb-4">
                <h6 class="text-danger fw-bold text-uppercase"><i class="bi bi-exclamation-triangle"></i> Blockers / Issues</h6>
                @if($dailyReport->blockers)
                    <div class="p-3 bg-danger bg-opacity-10 border-start border-3 border-danger rounded text-dark" style="white-space: pre-line;">{{ $dailyReport->blockers }}</div>
                @else
                    <div class="p-3 bg-light rounded text-muted fst-italic">No blockers recorded for this date.</div>
                @endif
            </div>
        </div>
        
    </div>
</div>
@endsection
