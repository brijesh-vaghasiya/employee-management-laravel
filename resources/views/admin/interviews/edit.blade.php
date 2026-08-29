@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h2><a href="{{ route('admin.interviews.index') }}" class="text-decoration-none text-dark"><i class="bi bi-arrow-left"></i> Candidates</a> / Edit</h2>
    <a href="{{ route('admin.interviews.evaluate', $interview->id) }}" class="btn btn-success"><i class="bi bi-ui-checks"></i> Goto Evaluation</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('admin.interviews.update', $interview->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row border-bottom pb-4 mb-4">
                <div class="col-12 mb-3">
                    <h5 class="text-primary border-bottom pb-2">Status & Approvals</h5>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Interview Status</label>
                    <select name="status" class="form-select">
                        <option value="Scheduled" {{ $interview->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="Completed" {{ $interview->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Hired" {{ $interview->status == 'Hired' ? 'selected' : '' }}>Hired</option>
                        <option value="Rejected" {{ $interview->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-9 mb-3 d-flex align-items-end gap-4 pb-1">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="bg_approval" value="1" id="bgApp" {{ $interview->bg_approval ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="bgApp">Background verified</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="edu_approval" value="1" id="eduApp" {{ $interview->edu_approval ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="eduApp">Education verified</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="salary_approval" value="1" id="salApp" {{ $interview->salary_approval ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="salApp">Salary agreed</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <h5 class="text-secondary border-bottom pb-2">Candidate Details</h5>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Candidate Name *</label>
                    <input type="text" name="candidate_name" class="form-control" value="{{ old('candidate_name', $interview->candidate_name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Position Applied For *</label>
                    <input type="text" name="position" class="form-control" value="{{ old('position', $interview->position) }}" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Interview Date *</label>
                    <input type="date" name="interview_date" class="form-control" value="{{ old('interview_date', \Carbon\Carbon::parse($interview->interview_date)->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Department</label>
                    <input type="text" name="department" class="form-control" value="{{ old('department', $interview->department) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Interviewer</label>
                    <input type="text" name="interviewer" class="form-control" value="{{ old('interviewer', $interview->interviewer) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Education</label>
                    <input type="text" name="education" class="form-control" value="{{ old('education', $interview->education) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Experience</label>
                    <input type="text" name="experience" class="form-control" value="{{ old('experience', $interview->experience) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Previous Company</label>
                    <input type="text" name="previous_company" class="form-control" value="{{ old('previous_company', $interview->previous_company) }}">
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label">Key Skills</label>
                    <textarea name="skills" class="form-control" rows="2">{{ old('skills', $interview->skills) }}</textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Current CTC (in lakhs/thousands)</label>
                    <input type="number" step="0.01" name="ctc" class="form-control" value="{{ old('ctc', $interview->ctc) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Expected CTC</label>
                    <input type="number" step="0.01" name="expected_ctc" class="form-control" value="{{ old('expected_ctc', $interview->expected_ctc) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Update CV (PDF/Word)</label>
                    <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
                    @if($interview->cv_path)
                        <div class="mt-2 text-sm text-info"><a href="{{ asset('storage/' . $interview->cv_path) }}" target="_blank"><i class="bi bi-file-text"></i> Current CV Attached</a></div>
                    @endif
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Additional Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $interview->notes) }}</textarea>
                </div>
            </div>

            <div class="text-end mt-3 border-top pt-3">
                <button type="submit" class="btn btn-primary px-4">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
