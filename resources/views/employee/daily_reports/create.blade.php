@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.daily_reports.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to History</a>
    <h2 class="mt-2 text-dark">Submit End-of-Day Report</h2>
</div>

<div class="card shadow-sm border-0 border-top border-4 border-primary" style="max-width: 900px;">
    <div class="card-body p-4">
        
        <form action="{{ route('employee.daily_reports.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="form-label fw-bold">Report Date <span class="text-danger">*</span></label>
                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">You can only submit one report per day.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">What tasks did you complete today? <span class="text-danger">*</span></label>
                <textarea name="completed_tasks" class="form-control @error('completed_tasks') is-invalid @enderror" rows="5" placeholder="1. Fixed issue with...&#10;2. Configured database...&#10;3. Called client regarding..." required>{{ old('completed_tasks') }}</textarea>
                @error('completed_tasks')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">What is your plan for tomorrow? <span class="text-danger">*</span></label>
                <textarea name="tomorrow_plan" class="form-control @error('tomorrow_plan') is-invalid @enderror" rows="3" placeholder="Tomorrow I plan to deploy the server and finish..." required>{{ old('tomorrow_plan') }}</textarea>
                @error('tomorrow_plan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Any blockers or issues? (Optional)</label>
                <textarea name="blockers" class="form-control @error('blockers') is-invalid @enderror" rows="2" placeholder="Waiting for API keys from John...">{{ old('blockers') }}</textarea>
                @error('blockers')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="text-end pt-3 border-top">
                <button type="submit" class="btn btn-primary px-5 fw-bold"><i class="bi bi-cloud-arrow-up"></i> Submit Daily Log</button>
            </div>
        </form>
    </div>
</div>
@endsection
