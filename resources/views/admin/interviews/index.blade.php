@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Interview Candidates</h2>
    <a href="{{ route('admin.interviews.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i> Add Candidate</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Candidate</th>
                        <th>Position</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>CV</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interviews as $interview)
                    <tr>
                        <td class="ps-3 fw-bold">
                            {{ $interview->candidate_name }}
                            <div class="small text-muted">{{ $interview->experience ?? 'Fresher' }} Exp</div>
                        </td>
                        <td>
                            {{ $interview->position }}
                            <div class="small text-muted">{{ $interview->department }}</div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($interview->interview_date)->format('M d, Y') }}</td>
                        <td>
                            @if($interview->status == 'Scheduled')
                                <span class="badge bg-primary">{{ $interview->status }}</span>
                            @elseif($interview->status == 'Completed')
                                <span class="badge bg-secondary">{{ $interview->status }}</span>
                            @elseif($interview->status == 'Hired')
                                <span class="badge bg-success">{{ $interview->status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $interview->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if($interview->cv_path)
                                <a href="{{ asset('storage/' . $interview->cv_path) }}" target="_blank" class="btn btn-sm btn-link"><i class="bi bi-file-earmark-person"></i> View</a>
                            @else
                                <span class="text-muted small">No CV</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.interviews.evaluate', $interview->id) }}" class="btn btn-sm btn-success" title="Evaluate"><i class="bi bi-ui-checks"></i></a>
                            <a href="{{ route('admin.interviews.edit', $interview->id) }}" class="btn btn-sm btn-outline-primary" title="Edit candidate"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.interviews.destroy', $interview->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this interview candidate?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No candidates registered.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($interviews->hasPages())
    <div class="card-footer bg-white border-0 pt-3">
        {{ $interviews->links() }}
    </div>
    @endif
</div>
@endsection
