@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Assign T-Shirts</h2>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold">
                Assign to Employee
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tshirt_assigns.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Employee</label>
                        <select name="employee_id" class="form-select" required>
                            <option value="">-- Employee --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Shirt (In Stock)</label>
                        <select name="tshirt_id" class="form-select" required>
                            <option value="">-- Select Design/Size --</option>
                            @foreach($tshirts as $tshirt)
                                <option value="{{ $tshirt->id }}">{{ $tshirt->design_name }} (Size: {{ $tshirt->size }}) - {{ $tshirt->stock }} left</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assigned Date</label>
                        <input type="date" name="assigned_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Assign Asset</button>
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
                            <th class="ps-3">Employee</th>
                            <th>T-Shirt Details</th>
                            <th>Date Assigned</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assign)
                        <tr>
                            <td class="ps-3 fw-bold">
                                @if($assign->employee)
                                {{ $assign->employee->first_name }} {{ $assign->employee->last_name }}
                                @else
                                <span class="text-danger">Deleted Employee</span>
                                @endif
                            </td>
                            <td>
                                @if($assign->tshirt)
                                {{ $assign->tshirt->design_name }} 
                                <span class="badge bg-info ms-1">{{ $assign->tshirt->size }}</span>
                                @else
                                <span class="text-danger">Deleted Item</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($assign->assigned_date)->format('M d, Y') }}</td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.tshirt_assigns.destroy', $assign->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Revoke this assignment? The stock will be returned to inventory.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i> Revoke</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No T-Shirts assigned yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($assignments->hasPages())
            <div class="card-footer bg-white border-0 pt-3">
                {{ $assignments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
