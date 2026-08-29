@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Holidays Management</h2>
    <a href="{{ route('admin.holidays.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Holiday</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Holiday Name</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($holidays as $holiday)
                    <tr>
                        <td class="ps-3 fw-bold">{{ $holiday->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($holiday->holiday_date)->format('M d, Y') }}</td>
                        <td class="text-muted">{{ Str::limit($holiday->description, 50) }}</td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.holidays.edit', $holiday) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.holidays.destroy', $holiday) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this holiday?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No holidays defined yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($holidays->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $holidays->links() }}
    </div>
    @endif
</div>
@endsection
