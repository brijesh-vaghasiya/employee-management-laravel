@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="javascript:history.back()" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back</a>
    <h2 class="mt-2">Assign New Task</h2>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.tasks.store') }}" method="POST">
            @csrf
            
            <div class="row align-items-center mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label">Project <span class="text-danger">*</span></label>
                    <select name="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ (old('project_id') ?? $selectedProject) == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Assign To (Employee) <span class="text-danger">*</span></label>
                    <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->department }})
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Task Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control fw-bold @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="E.g., Design Database Schema" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Description / Instructions</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Detailed instructions for the employee...">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Initial Status</label>
                    <select name="status" class="form-select bg-light">
                        <option value="To Do">To Do</option>
                        <option value="In Progress">In Progress</option>
                    </select>
                </div>
            </div>

            <div class="text-end border-top pt-4">
                <button type="submit" class="btn btn-primary px-5"><i class="bi bi-send"></i> Assign Task</button>
            </div>
        </form>
    </div>
</div>
@endsection
