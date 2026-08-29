@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('admin.projects.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> All Projects</a>
        <h2 class="mt-2 mb-0">{{ $project->name }}</h2>
        <p class="text-muted small mt-1 mb-0">{{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }} - {{ $project->end_date ? $project->end_date->format('M d, Y') : 'No deadline' }} | Status: <strong>{{ $project->status }}</strong></p>
    </div>
    
    <div>
        <a href="{{ route('admin.tasks.create', ['project_id' => $project->id]) }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Create Task</a>
    </div>
</div>

<div class="row">
    @php
        $columns = [
            'To Do' => $project->tasks->where('status', 'To Do'),
            'In Progress' => $project->tasks->where('status', 'In Progress'),
            'Review' => $project->tasks->where('status', 'Review'),
            'Done' => $project->tasks->where('status', 'Done')
        ];
        
        $colColors = [
            'To Do' => 'border-primary',
            'In Progress' => 'border-warning',
            'Review' => 'border-info',
            'Done' => 'border-success'
        ];
    @endphp

    @foreach($columns as $colName => $colTasks)
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm rounded-3 bg-light h-100 border-top border-4 {{ $colColors[$colName] }}">
            <div class="card-header bg-transparent fw-bold d-flex justify-content-between align-items-center">
                {{ $colName }}
                <span class="badge bg-secondary rounded-pill">{{ count($colTasks) }}</span>
            </div>
            <div class="card-body p-2" style="min-height: 400px; overflow-y: auto;">
                
                @forelse($colTasks as $task)
                    <div class="card shadow-sm border-0 mb-3" style="font-size: 0.9rem;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-2">
                                @php
                                    $prioBadge = match($task->priority) {
                                        'High' => 'bg-danger text-white',
                                        'Medium' => 'bg-warning text-dark',
                                        'Low' => 'bg-info text-dark',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $prioBadge }}" style="font-size: 0.7rem;">{{ $task->priority }}</span>
                                <div class="dropdown">
                                    <a href="#" class="text-muted" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li>
                                            <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <h6 class="fw-bold mb-1">{{ $task->title }}</h6>
                            <p class="text-muted small text-truncate mb-2" title="{{ $task->description }}">{{ $task->description }}</p>
                            
                            <hr class="my-2">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center" title="Assigned to {{ $task->employee->first_name }}">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 25px; height: 25px; font-size: 0.75rem;">
                                        {{ substr($task->employee->first_name, 0, 1) }}{{ substr($task->employee->last_name, 0, 1) }}
                                    </div>
                                    <small>{{ $task->employee->first_name }}</small>
                                </div>
                                @if($task->due_date)
                                <small class="text-muted {{ $task->due_date < now() && $task->status !== 'Done' ? 'text-danger fw-bold' : '' }}">
                                    <i class="bi bi-clock"></i> {{ $task->due_date->format('M d') }}
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-3 text-muted small border rounded border-dashed" style="border-style: dashed !important;">
                        No tasks
                    </div>
                @endforelse
                
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
