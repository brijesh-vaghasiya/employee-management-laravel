@extends('layouts.asc')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-building text-success me-2"></i> Projects & Roles</h2>
</div>

<div class="row">
    <!-- Projects Section -->
    <div class="col-md-7 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3">Project Infrastructure</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td class="ps-4">
                                <h6 class="fw-bold mb-1">{{ $project->name }}</h6>
                                <p class="small text-muted mb-2">{{ $project->description }}</p>
                                
                                <!-- Roles associated with Project -->
                                <div class="d-flex flex-wrap gap-1 mt-2">
                                    @foreach($project->roles as $role)
                                    <div class="badge bg-secondary d-flex align-items-center">
                                        {{ $role->role_name }}
                                        <form action="{{ route('asc.projects.roles.destroy', $role->id) }}" method="POST" class="ms-2 d-inline" onsubmit="return confirm('Delete this role binding?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-close btn-close-white" style="font-size: 0.5rem;"></button>
                                        </form>
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <!-- Trigger Modal for Add Role -->
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addRoleModal{{ $project->id }}" title="Add Role Binding">
                                    <i class="bi bi-person-plus"></i> Add Role
                                </button>
                                <form action="{{ route('asc.projects.destroy', $project->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Nuke this project entirely? Cascades destruction to all bindings!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Nuke</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Add Role Modal -->
                        <div class="modal fade" id="addRoleModal{{ $project->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title">Add Role to {{ $project->name }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('asc.projects.roles.store', $project->id) }}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="mb-3 text-start">
                                                <label class="form-label text-dark">Role Name</label>
                                                <input type="text" name="role_name" class="form-control" placeholder="e.g. Developer, Lead" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary w-100">Bind Role</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="2" class="text-center py-5 text-muted">No infrastructure projects initiated.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($projects->hasPages())
            <div class="card-footer bg-white border-0 pt-3">
                {{ $projects->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Create Project Form -->
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
            <div class="card-header bg-dark text-white fw-bold py-3 text-center">
                Initialize Project Scaffold
            </div>
            <div class="card-body">
                <form action="{{ route('asc.projects.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Project Domain Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Nexus Core" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Objective Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Top-level project scope..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Initialize Infrastructure</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
