@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.review_cycles.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Review Cycles</a>
    <h2 class="mt-2">Initiate Review Cycle</h2>
</div>

<div class="card shadow-sm border-0" style="max-width: 650px;">
    <div class="card-body p-4">
        
        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-4">
            <i class="bi bi-info-circle fs-3 me-3"></i>
            <div>
                <strong>What is a Review Cycle?</strong><br>
                A designated time period where employees across the company can formally submit self-evaluations for management to review (e.g. "Annual Review 2026").
            </div>
        </div>

        <form action="{{ route('admin.review_cycles.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="form-label fw-bold">Cycle Identifier Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g., 2026 Annual Performance Review" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Evaluation Window Start Date</label>
                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', now()->format('Y-m-d')) }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Hard Deadline for Submission</label>
                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', now()->addDays(30)->format('Y-m-d')) }}" required>
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check form-switch fs-5">
                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActiveSwitch" checked>
                    <label class="form-check-label ms-2" for="isActiveSwitch">Activate immediately</label>
                </div>
                <div class="form-text mt-2">Active cycles instantly alert all employees to start submitting self-appraisals. Inactive cycles are closed for submissions.</div>
            </div>

            <div class="text-end border-top pt-4">
                <button type="submit" class="btn btn-primary px-5"><i class="bi bi-shield-check"></i> Formulate Cycle</button>
            </div>
        </form>
    </div>
</div>
@endsection
