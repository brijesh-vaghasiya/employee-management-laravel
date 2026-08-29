@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.appraisals.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Appraisals</a>
    <h2 class="mt-2">Self Appraisal Submission</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 border-top border-4 border-primary">
            <div class="card-body p-4">
                <div class="alert alert-primary bg-primary bg-opacity-10 border-0 mb-4">
                    <h5 class="fw-bold mb-1">{{ $cycle->name }}</h5>
                    <p class="mb-0 small"><i class="bi bi-calendar3"></i> Evaluation Window: {{ $cycle->start_date->format('M d, Y') }} - {{ $cycle->end_date->format('M d, Y') }}</p>
                </div>
                
                <form action="{{ route('employee.appraisals.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="review_cycle_id" value="{{ $cycle->id }}">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark fs-5">Self Review & Accomplishments <span class="text-danger">*</span></label>
                        <p class="text-muted small mb-2">Detail your key achievements, challenges overcome, and goals met during this evaluation period. Be as specific as possible to assist management in your review. (Minimum 50 characters)</p>
                        <textarea name="self_review" class="form-control @error('self_review') is-invalid @enderror" rows="10" placeholder="e.g. During this quarter, I successfully delivered the migration project 2 weeks ahead of schedule, which resulted in a 30% pipeline efficiency boost..." required minlength="50">{{ old('self_review') }}</textarea>
                        @error('self_review')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold" onclick="return confirm('Are you sure you want to submit? This cannot be edited later.')"><i class="bi bi-send-check"></i> Submit Self Evaluation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body p-4">
                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-lightbulb"></i> Tips for a Great Self Review</h6>
                <ul class="text-muted small ps-3">
                    <li class="mb-2"><strong>Highlight metrics.</strong> Use real numbers to demonstrate your impact.</li>
                    <li class="mb-2"><strong>Acknowledge challenges.</strong> Speak honestly about hurdles and how you adapted.</li>
                    <li class="mb-2"><strong>Connect to company goals.</strong> Show how your work aligned with corporate milestones.</li>
                    <li><strong>Propose future growth.</strong> End with what you want to learn or achieve in the next cycle.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
