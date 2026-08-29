@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.projects.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Projects</a>
    <h2 class="mt-2">Create New Project</h2>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Project Title <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description <span class="text-muted">(Optional)</span></label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="On Hold" {{ old('status') == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">Create Project</button>
            </div>
        </form>
    </div>
</div>
@endsection
