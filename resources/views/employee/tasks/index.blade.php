@extends('layouts.employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Assigned Tasks</h2>
    <div class="text-muted"><i class="bi bi-clock-history"></i> Manage your priorities</div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Task Name & Description</th>
                                <th>Project</th>
                                <th>Priority</th>
                                <th>Due Date</th>
                                <th class="text-center">Status Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold mb-1 {{ $task->status == 'Done' ? 'text-decoration-line-through text-muted' : '' }}">{{ $task->title }}</div>
                                    <small class="text-muted d-block text-wrap" style="max-width: 350px;">{{ Str::limit($task->description, 100) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-primary border border-primary"><i class="bi bi-diagram-3"></i> {{ $task->project->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @php
                                        $prioBadge = match($task->priority) {
                                            'High' => 'text-danger',
                                            'Medium' => 'text-warning',
                                            'Low' => 'text-info',
                                            default => 'text-secondary'
                                        };
                                    @endphp
                                    <span class="fw-bold {{ $prioBadge }}"><i class="bi bi-flag-fill"></i> {{ $task->priority }}</span>
                                </td>
                                <td>
                                    @if($task->due_date)
                                        <span class="{{ $task->due_date < now() && $task->status != 'Done' ? 'text-danger fw-bold' : 'text-muted' }}">
                                            {{ $task->due_date->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">No Date</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4" style="min-width: 180px;">
                                    <form action="{{ route('employee.tasks.update', $task) }}" method="POST" class="d-flex align-items-center justify-content-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm shadow-none border-1 me-2" onchange="this.form.submit()" style="max-width: 130px; font-weight: 500;">
                                            <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                            <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="Review" {{ $task->status == 'Review' ? 'selected' : '' }}>Review</option>
                                            <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-check2-circle fs-2 d-block mb-2"></i> You have no tasks assigned!</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($tasks->hasPages())
            <div class="card-footer bg-white pt-3 border-0">
                {{ $tasks->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
