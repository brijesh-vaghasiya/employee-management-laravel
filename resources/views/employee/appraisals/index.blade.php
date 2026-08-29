@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <h2>Performance Appraisals</h2>
    <p class="text-muted">Track your reviews and participate in active evaluation cycles.</p>
</div>

<div class="row mb-5">
    <div class="col-12">
        <h5 class="text-primary mb-3"><i class="bi bi-broadcast"></i> Active Review Cycles</h5>
        <div class="row">
            @forelse($activeCycles as $cycle)
                @php
                    $alreadySubmitted = $appraisals->contains('review_cycle_id', $cycle->id);
                @endphp
                <div class="col-md-6 mb-3">
                    <div class="card border-0 shadow-sm border-start border-4 {{ $alreadySubmitted ? 'border-success' : 'border-warning' }} h-100">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $cycle->name }}</h5>
                                <div class="text-muted small mb-2"><i class="bi bi-calendar-event"></i> Closes {{ $cycle->end_date->format('M d, Y') }}</div>
                                @if($alreadySubmitted)
                                    <span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle"></i> You have already submitted</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning text-dark"><i class="bi bi-exclamation-circle"></i> Awaiting your submission</span>
                                @endif
                            </div>
                            @if(!$alreadySubmitted)
                                <div>
                                    <a href="{{ route('employee.appraisals.create', ['cycle_id' => $cycle->id]) }}" class="btn btn-primary shadow-sm">Take Assessment <i class="bi bi-arrow-right"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border-0 shadow-sm text-muted d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle fs-4 me-3"></i>
                        <div>There are currently no active performance review cycles open for submissions.</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h5 class="text-secondary mb-3"><i class="bi bi-clock-history"></i> Your Historical Evaluations</h5>
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Review Cycle</th>
                                <th>Submitted On</th>
                                <th>Status</th>
                                <th>Management Rating</th>
                                <th class="text-end pe-4">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appraisals as $app)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $app->reviewCycle->name }}</td>
                                <td class="text-muted">{{ $app->created_at->format('M d, Y') }}</td>
                                <td>
                                    @php
                                        $sBadge = match($app->status) {
                                            'Employee Submitted' => 'bg-warning text-dark',
                                            'Evaluated' => 'bg-success',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $sBadge }}">{{ $app->status }}</span>
                                </td>
                                <td>
                                    @if($app->rating)
                                        <div class="text-warning fs-5" title="{{ $app->rating }} out of 5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $app->rating ? '-fill' : '' }}"></i>
                                            @endfor
                                        </div>
                                    @else
                                        <span class="text-muted small">Pending Review</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $app->id }}">View Results</button>
                                    
                                    <!-- Results Modal -->
                                    <div class="modal fade" id="viewModal{{ $app->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered text-start">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-light py-3 border-0">
                                                    <h5 class="modal-title fw-bold text-dark">{{ $app->reviewCycle->name }} Results</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <h6 class="text-muted mb-2"><i class="bi bi-journal-text me-1"></i> Your Self Review</h6>
                                                    <div class="p-3 bg-light rounded text-dark mb-4" style="white-space: pre-line;">{{ $app->self_review }}</div>
                                                    
                                                    @if($app->status == 'Evaluated')
                                                        <hr class="my-4">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h6 class="text-primary fw-bold mb-0"><i class="bi bi-award me-1"></i> Management Feedback</h6>
                                                            <div class="text-warning fs-4">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="bi bi-star{{ $i <= $app->rating ? '-fill' : '' }}"></i>
                                                                @endfor
                                                                <span class="text-dark fs-6 fw-bold ms-2">{{ $app->rating }}/5 Ranked</span>
                                                            </div>
                                                        </div>
                                                        <div class="p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded text-dark" style="white-space: pre-line;">{{ $app->manager_review }}</div>
                                                    @else
                                                        <div class="alert alert-warning text-center mt-4 border-0">
                                                            <i class="bi bi-hourglass-split"></i> Management has not yet evaluated your submission. Check back later once the cycle concludes!
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">You have no historical appraisal records in the system.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
