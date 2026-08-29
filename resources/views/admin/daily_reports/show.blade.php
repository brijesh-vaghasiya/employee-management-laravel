@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('admin.daily_reports.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Reports Board</a>
    
    <form action="{{ route('admin.daily_reports.updateStatus', $dailyReport) }}" method="POST">
        @csrf
        @method('PUT')
        @if($dailyReport->status == 'Pending')
            <input type="hidden" name="status" value="Verified">
            <button type="submit" class="btn btn-success fw-bold shadow-sm px-4"><i class="bi bi-check2-circle"></i> Acknowledge & Verify Report</button>
        @else
            <input type="hidden" name="status" value="Pending">
            <button type="button" class="btn btn-outline-success disabled"><i class="bi bi-shield-check"></i> Already Verified</button>
        @endif
    </form>
</div>

<div class="card shadow-sm border-0 border-top border-4 {{ $dailyReport->status == 'Verified' ? 'border-success' : 'border-primary' }}">
    <div class="card-body p-5">
        <div class="row border-bottom pb-4 mb-4">
            <div class="col-md-6 border-end">
                <h6 class="text-muted mb-2 text-uppercase small fw-bold">Employee Profile</h6>
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 45px; height: 45px;">
                        <i class="bi bi-person fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">{{ $dailyReport->employee->first_name }} {{ $dailyReport->employee->last_name }}</h5>
                        <p class="text-muted mb-0 small">{{ $dailyReport->employee->designation }} • {{ $dailyReport->employee->department }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ps-4">
                <h6 class="text-muted mb-2 text-uppercase small fw-bold">Filing Record</h6>
                <h5 class="fw-bold text-dark"><i class="bi bi-calendar2-range me-2 text-primary"></i> {{ $dailyReport->date->format('l, F j, Y') }}</h5>
                <div class="small mt-2">
                    <span class="text-muted me-2">Submission Status:</span> 
                    @if($dailyReport->status == 'Verified')
                        <span class="badge bg-success">Verified</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending Evaluation</span>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 mb-4">
                <h6 class="text-primary fw-bold text-uppercase"><i class="bi bi-check-all"></i> End Of Day Execution</h6>
                <div class="p-4 bg-light rounded text-dark fs-6 border" style="white-space: pre-line;">{{ $dailyReport->completed_tasks }}</div>
            </div>
            
            <div class="col-md-6 mb-4">
                <h6 class="text-secondary fw-bold text-uppercase"><i class="bi bi-arrow-return-right"></i> Strategy for Tomorrow</h6>
                <div class="p-4 bg-light rounded text-dark border-start border-4 border-secondary shadow-sm" style="white-space: pre-line; min-height: 100px;">{{ $dailyReport->tomorrow_plan }}</div>
            </div>
            
            <div class="col-md-6 mb-4">
                <h6 class="text-danger fw-bold text-uppercase"><i class="bi bi-exclamation-triangle"></i> Identified Blockers</h6>
                @if($dailyReport->blockers)
                    <div class="p-4 bg-danger bg-opacity-10 border-start border-4 border-danger rounded text-dark shadow-sm" style="white-space: pre-line; min-height: 100px;">{{ $dailyReport->blockers }}</div>
                @else
                    <div class="p-4 bg-light rounded text-muted shadow-sm fst-italic" style="min-height: 100px;">Employee reported no roadblocks.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
