@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Helpdesk Request Types</h2>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold">
                Add Ticket Category
            </div>
            <div class="card-body">
                <form action="{{ route('admin.request_options.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. IT Support, Cleanliness" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Option</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Request/Ticket Option</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($options as $option)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $option->name }}</td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.request_options.destroy', $option->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this option? It may cascade to employee requests.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center py-4 text-muted">No request templates added.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($options->hasPages())
            <div class="card-footer bg-white border-0 pt-3">
                {{ $options->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
