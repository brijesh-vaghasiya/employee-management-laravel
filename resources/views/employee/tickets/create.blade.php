@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.tickets.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Tickets</a>
    <h2 class="mt-2 text-dark">Raise a Support Ticket</h2>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        
        <form action="{{ route('employee.tickets.store') }}" method="POST">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Support Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="">Select a department...</option>
                        <option value="IT Support" {{ old('category') == 'IT Support' ? 'selected' : '' }}>💻 IT Support & Hardware</option>
                        <option value="HR Query" {{ old('category') == 'HR Query' ? 'selected' : '' }}>👩‍💼 HR/Onboarding Query</option>
                        <option value="Payroll" {{ old('category') == 'Payroll' ? 'selected' : '' }}>💰 Payroll & Reimbursements</option>
                        <option value="Facilities" {{ old('category') == 'Facilities' ? 'selected' : '' }}>🏢 Facilities & Maintenance</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Priority Level <span class="text-danger">*</span></label>
                    <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>🟢 Low - General Inquiry</option>
                        <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>🟡 Medium - Needs Attention</option>
                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>🟠 High - Blocking my work</option>
                        <option value="Critical" {{ old('priority') == 'Critical' ? 'selected' : '' }}>🔴 Critical - System down/Emergency</option>
                    </select>
                    @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Issue Subject / Summary <span class="text-danger">*</span></label>
                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="Briefly describe the issue..." required>
                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Detailed Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="Provide as much context as possible so we can resolve this quickly." required>{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="text-end pt-3 border-top">
                <button type="submit" class="btn btn-primary px-5"><i class="bi bi-send"></i> Submit Ticket</button>
            </div>
        </form>
    </div>
</div>
@endsection
