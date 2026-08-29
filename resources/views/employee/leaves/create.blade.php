@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.leaves.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Leaves</a>
    <h2 class="mt-2">Apply for Leave</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('employee.leaves.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Leave Type <span class="text-danger">*</span></label>
                        <select name="leave_type" class="form-select @error('leave_type') is-invalid @enderror" required>
                            <option value="">Select leave type</option>
                            <option value="Casual Leave" {{ old('leave_type') == 'Casual Leave' ? 'selected' : '' }}>Casual Leave</option>
                            <option value="Sick Leave" {{ old('leave_type') == 'Sick Leave' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="Earned Leave" {{ old('leave_type') == 'Earned Leave' ? 'selected' : '' }}>Earned Leave</option>
                            <option value="Unpaid Leave" {{ old('leave_type') == 'Unpaid Leave' ? 'selected' : '' }}>Unpaid Leave</option>
                        </select>
                        @error('leave_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">From Date <span class="text-danger">*</span></label>
                            <input type="date" name="from_date" id="from_date" class="form-control @error('from_date') is-invalid @enderror" value="{{ old('from_date') }}" required>
                            @error('from_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">To Date <span class="text-danger">*</span></label>
                            <input type="date" name="to_date" id="to_date" class="form-control @error('to_date') is-invalid @enderror" value="{{ old('to_date') }}" required>
                            @error('to_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Reason <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" rows="4" placeholder="Briefly explain your reason for leave..." required>{{ old('reason') }}</textarea>
                        @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4 bg-light">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="bi bi-info-circle text-primary"></i> Leave Rules</h5>
                <ul class="text-muted small ps-3 mt-3">
                    <li class="mb-2">Ensure you apply for planned leaves at least 7 days in advance.</li>
                    <li class="mb-2">Sick leaves require a medical certificate if applied for more than 2 consecutive days.</li>
                    <li class="mb-2">Once submitted, you cannot modify the leave application. If you need to make changes, contact HR.</li>
                    <li>Unpaid leaves are subject to managerial discretion.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fromDate = document.getElementById('from_date');
        const toDate = document.getElementById('to_date');
        
        // Auto update minimum to_date based on from_date
        fromDate.addEventListener('change', function() {
            if (this.value) {
                toDate.min = this.value;
                if(toDate.value && toDate.value < this.value) {
                    toDate.value = this.value;
                }
            }
        });
    });
</script>
@endpush
@endsection
