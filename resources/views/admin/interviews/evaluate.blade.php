@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h2><a href="{{ route('admin.interviews.index') }}" class="text-decoration-none text-dark"><i class="bi bi-arrow-left"></i> Candidates</a> / Evaluate</h2>
    <p class="text-muted">Scoring candidate: <strong>{{ $interview->candidate_name }}</strong> for <strong>{{ $interview->position }}</strong></p>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="{{ route('admin.interviews.save_evaluation', $interview->id) }}" method="POST">
            @csrf
            
            <div class="accordion" id="accordionEvaluation">
                @forelse($categories as $category)
                    @if($category->questions->count() > 0)
                        <div class="accordion-item mb-3 border bg-white shadow-sm rounded overflow-hidden">
                            <h2 class="accordion-header" id="heading{{ $category->id }}">
                                <button class="accordion-button bg-light fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category->id }}" aria-expanded="true" aria-controls="collapse{{ $category->id }}">
                                    {{ $category->name }} Assessment
                                </button>
                            </h2>
                            <div id="collapse{{ $category->id }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $category->id }}">
                                <div class="accordion-body">
                                    <table class="table table-borderless align-middle mb-0">
                                        <tbody>
                                            @foreach($category->questions as $question)
                                                @php
                                                    $existingScore = $existingResults->has($question->id) ? $existingResults[$question->id]->score : 0;
                                                    $existingRemarks = $existingResults->has($question->id) ? $existingResults[$question->id]->remarks : '';
                                                @endphp
                                                <tr class="border-bottom">
                                                    <td class="w-50 pt-3">
                                                        {{ $question->question }}
                                                    </td>
                                                    <td class="pt-3" style="width: 15%">
                                                        <select name="scores[{{ $question->id }}]" class="form-select form-select-sm border-primary text-primary fw-bold text-center">
                                                            @for($i=0; $i<=10; $i++)
                                                                <option value="{{ $i }}" {{ $existingScore == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td class="pt-3" style="width: 35%">
                                                        <input type="text" name="remarks[{{ $question->id }}]" class="form-control form-control-sm" placeholder="Remarks..." value="{{ $existingRemarks }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="alert alert-info">No evaluation categories set up yet. Go to Interview Categories to create a scoring rubric.</div>
                @endforelse
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body bg-light rounded text-end">
                    <div class="d-inline-flex align-items-center gap-3">
                        <label class="fw-bold mb-0">Update Status:</label>
                        <select name="status" class="form-select form-select-sm w-auto d-inline-block shadow-sm">
                            <option value="Scheduled" {{ $interview->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="Completed" {{ $interview->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Hired" {{ $interview->status == 'Hired' ? 'selected' : '' }}>Hired</option>
                            <option value="Rejected" {{ $interview->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow">Save Evaluation</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Candidate Sidebar Info -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
            <div class="card-header bg-dark text-white fw-bold">Candidate Info</div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="display-1 text-muted"><i class="bi bi-person-bounding-box"></i></div>
                    <h5 class="fw-bold mt-2 mb-0">{{ $interview->candidate_name }}</h5>
                    <span class="text-muted small">{{ $interview->position }}</span>
                </div>
                <hr>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><strong>Experience:</strong> {{ $interview->experience ?? 'N/A' }}</li>
                    <li class="mb-2"><strong>Department:</strong> {{ $interview->department ?? 'N/A' }}</li>
                    <li class="mb-2"><strong>Skills:</strong> {{ $interview->skills ?? 'N/A' }}</li>
                    <li class="mb-2">
                        <strong>CV:</strong> 
                        @if($interview->cv_path)
                            <a href="{{ asset('storage/' . $interview->cv_path) }}" target="_blank">View File</a>
                        @else
                            Not provided
                        @endif
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-white border-0 text-center">
                <a href="{{ route('admin.interviews.edit', $interview->id) }}" class="btn btn-sm btn-outline-secondary w-100">Edit Details</a>
            </div>
        </div>
    </div>
</div>
@endsection
