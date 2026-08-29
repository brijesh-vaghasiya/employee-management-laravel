@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Performance Review Cycles</h2>
    <a href="{{ route('admin.review_cycles.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Initiate Cycle</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Cycle Name</th>
                        <th>Duration Window</th>
                        <th>Submissions</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cycles as $cycle)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">{{ $cycle->name }}</td>
                        <td>
                            <i class="bi bi-calendar3 text-muted"></i> {{ $cycle->start_date->format('M d, Y') }} 
                            <i class="bi bi-arrow-right mx-1 text-muted"></i> 
                            {{ $cycle->end_date->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-light text-dark border border-secondary px-2 py-1 fs-6">
                                    {{ $cycle->appraisals()->count() }} Appraisals
                                </span>
                            </div>
                        </td>
                        <td>
                            @if($cycle->is_active)
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Active</span>
                            @else
                                <span class="badge bg-secondary"><i class="bi bi-lock"></i> Closed</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.appraisals.index', ['cycle_id' => $cycle->id]) }}" class="btn btn-sm btn-outline-info me-1" title="View Submissions"><i class="bi bi-invoices"></i> Evaluate Submissions</a>
                            <a href="{{ route('admin.review_cycles.edit', $cycle) }}" class="btn btn-sm btn-outline-primary" title="Edit Properties"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">No review cycles have been created. Initiate one to start collecting employee self-appraisals.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($cycles->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $cycles->links() }}
    </div>
    @endif
</div>
@endsection
