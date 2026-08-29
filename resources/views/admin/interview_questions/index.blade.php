@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Interview Questions</h2>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold">
                Add New Question
            </div>
            <div class="card-body">
                <form action="{{ route('admin.interview_questions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="interview_category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <textarea name="question" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Question</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body py-2">
                <form method="GET" action="{{ route('admin.interview_questions.index') }}" class="row g-2 align-items-center">
                    <div class="col-auto">
                        <strong>Filter by Category:</strong>
                    </div>
                    <div class="col-auto">
                        <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3 w-50">Question</th>
                            <th>Category</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                        <tr>
                            <td class="ps-3">{{ $question->question }}</td>
                            <td><span class="badge bg-secondary">{{ $question->category->name ?? 'Uncategorized' }}</span></td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.interview_questions.destroy', $question->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this question?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-4 text-muted">No questions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($questions->hasPages())
            <div class="card-footer bg-white border-0 pt-3">
                {{ $questions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
