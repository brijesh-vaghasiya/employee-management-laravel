@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h2><a href="{{ route('admin.interviews.index') }}" class="text-decoration-none text-dark"><i class="bi bi-arrow-left"></i> Candidates</a> / Create</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">
        Candidate Information
    </div>
    <div class="card-body">
        <form action="{{ route('admin.interviews.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Candidate Name *</label>
                    <input type="text" name="candidate_name" class="form-control" value="{{ old('candidate_name') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Position Applied For *</label>
                    <input type="text" name="position" class="form-control" value="{{ old('position') }}" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Interview Date *</label>
                    <input type="date" name="interview_date" class="form-control" value="{{ old('interview_date') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Department</label>
                    <input type="text" name="department" class="form-control" value="{{ old('department') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Interviewer</label>
                    <input type="text" name="interviewer" class="form-control" value="{{ old('interviewer') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Education</label>
                    <input type="text" name="education" class="form-control" value="{{ old('education') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Experience</label>
                    <input type="text" name="experience" class="form-control" placeholder="e.g. 2 Years" value="{{ old('experience') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Previous Company</label>
                    <input type="text" name="previous_company" class="form-control" value="{{ old('previous_company') }}">
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label">Key Skills</label>
                    <textarea name="skills" class="form-control" rows="2">{{ old('skills') }}</textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Current CTC (in lakhs/thousands)</label>
                    <input type="number" step="0.01" name="ctc" class="form-control" value="{{ old('ctc') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Expected CTC</label>
                    <input type="number" step="0.01" name="expected_ctc" class="form-control" value="{{ old('expected_ctc') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Upload CV (PDF/Word)</label>
                    <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Initial Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="text-end mt-3 border-top pt-3">
                <button type="submit" class="btn btn-primary px-4">Register Candidate</button>
            </div>
        </form>
    </div>
</div>
@endsection
