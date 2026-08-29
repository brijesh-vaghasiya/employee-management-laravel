@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2>Appraisal Board</h2>
        <p class="text-muted small">Evaluate incoming employee self-reviews.</p>
    </div>
    
    <form action="{{ route('admin.appraisals.index') }}" method="GET" class="d-flex">
        <select name="cycle_id" class="form-select bg-light border-0 shadow-sm custom-select me-2" onchange="this.form.submit()">
            <option value="">All Review Cycles</option>
            @foreach($cycles as $c)
                <option value="{{ $c->id }}" {{ request('cycle_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Employee</th>
                                <th>Review Cycle</th>
                                <th>Status</th>
                                <th class="text-center">Final Rating</th>
                                <th class="text-end pe-4">Evaluate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appraisals as $appraisal)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $appraisal->employee->first_name }} {{ $appraisal->employee->last_name }}</div>
                                    <div class="text-muted small">{{ $appraisal->employee->employee_code }} • {{ $appraisal->employee->department }}</div>
                                </td>
                                <td><span class="badge border border-primary text-primary">{{ $appraisal->reviewCycle->name }}</span></td>
                                <td>
                                    @php
                                        $badge = match($appraisal->status) {
                                            'Employee Submitted' => 'bg-warning text-dark',
                                            'Evaluated' => 'bg-success',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $appraisal->status }}</span>
                                </td>
                                <td class="text-center">
                                    @if($appraisal->rating)
                                        <div class="text-warning fs-5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $appraisal->rating ? '-fill' : '' }}"></i>
                                            @endfor
                                        </div>
                                    @else
                                        <span class="text-muted small"><i class="bi bi-hourglass-split"></i> Awaiting</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#evalModal{{ $appraisal->id }}">
                                        {{ $appraisal->status == 'Evaluated' ? 'View/Edit' : 'Evaluate Now' }}
                                    </button>
                                    
                                    <!-- Evaluation Modal -->
                                    <div class="modal fade" id="evalModal{{ $appraisal->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered text-start">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-light border-0 py-3">
                                                    <h5 class="modal-title fw-bold text-primary">Performance Evaluation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.appraisals.update', $appraisal) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body p-4">
                                                        <div class="row mb-4">
                                                            <div class="col-md-6 border-end">
                                                                <h6 class="text-muted mb-3"><i class="bi bi-person-badge"></i> Employee Details</h6>
                                                                <div class="fw-bold fs-5">{{ $appraisal->employee->first_name }} {{ $appraisal->employee->last_name }}</div>
                                                                <div class="text-muted">{{ $appraisal->employee->designation }}</div>
                                                            </div>
                                                            <div class="col-md-6 ps-md-4">
                                                                <h6 class="text-muted mb-3"><i class="bi bi-calendar-event"></i> Evaluation Cycle</h6>
                                                                <div class="fw-bold">{{ $appraisal->reviewCycle->name }}</div>
                                                                <div class="text-secondary small">{{ $appraisal->created_at->format('M d, Y g:i A') }}</div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card bg-light border-0 shadow-none mb-4">
                                                            <div class="card-body">
                                                                <h6 class="card-subtitle mb-2 text-primary fw-bold"><i class="bi bi-chat-left-quote"></i> Self Review (Employee Comments)</h6>
                                                                <p class="card-text text-dark" style="white-space: pre-line;">{{ $appraisal->self_review ?? 'No self-review provided.' }}</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <hr class="my-4">
                                                        
                                                        <h6 class="text-dark fw-bold mb-3">Management Verdict</h6>
                                                        <div class="mb-3">
                                                            <label class="form-label text-muted">Final Rating <span class="text-danger">*</span></label>
                                                            <select name="rating" class="form-select w-50" required>
                                                                <option value="">Select Stars (1-5)</option>
                                                                <option value="5" {{ $appraisal->rating == 5 ? 'selected' : '' }}>5 Stars - Outstanding Performance</option>
                                                                <option value="4" {{ $appraisal->rating == 4 ? 'selected' : '' }}>4 Stars - Exceeds Expectations</option>
                                                                <option value="3" {{ $appraisal->rating == 3 ? 'selected' : '' }}>3 Stars - Meets Expectations</option>
                                                                <option value="2" {{ $appraisal->rating == 2 ? 'selected' : '' }}>2 Stars - Needs Improvement</option>
                                                                <option value="1" {{ $appraisal->rating == 1 ? 'selected' : '' }}>1 Star - Unsatisfactory</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-muted">Manager Feedback / Directives <span class="text-danger">*</span></label>
                                                            <textarea name="manager_review" class="form-control" rows="5" placeholder="Provide constructive feedback, goals for next cycle, etc." required>{{ $appraisal->manager_review }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light border-0 py-3">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check2-circle"></i> Commit Evaluation</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">No appraisals have been submitted currently.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($appraisals->hasPages())
            <div class="card-footer bg-white pt-3 border-0">
                {{ $appraisals->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
