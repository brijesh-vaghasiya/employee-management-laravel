@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Project Management</h2>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Project</a>
</div>

<div class="row">
    @forelse($projects as $project)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title text-primary mb-0">{{ $project->name }}</h5>
                    @php
                        $badge = match($project->status) {
                            'Active' => 'bg-success',
                            'Completed' => 'bg-primary',
                            'On Hold' => 'bg-warning text-dark',
                            default => 'bg-secondary'
                        };
                    @endphp
                    <span class="badge {{ $badge }}">{{ $project->status }}</span>
                </div>
                <p class="text-muted small mb-3">{{ Str::limit($project->description, 80) }}</p>
                
                <div class="d-flex justify-content-between text-muted small mb-3">
                    <span><i class="bi bi-calendar3"></i> {{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</span>
                    <span><i class="bi bi-flag"></i> {{ $project->end_date ? $project->end_date->format('M d, Y') : 'N/A' }}</span>
                </div>
                
                <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-auto">
                    <div class="text-secondary fw-bold">
                        <i class="bi bi-list-task"></i> {{ $project->tasks_count }} Tasks
                    </div>
                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-outline-primary">Manage Board <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-5">
        <i class="bi bi-kanban fs-1 mb-3 d-block"></i>
        <p>No projects found. Create one to start assigning tasks.</p>
    </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $projects->links() }}
</div>
@endsection
