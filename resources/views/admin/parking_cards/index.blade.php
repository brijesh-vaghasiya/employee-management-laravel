@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Assign Parking Cards</h2>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold">
                Map Vehicle & Card
            </div>
            <div class="card-body">
                <form action="{{ route('admin.parking_cards.store') }}" method="POST">
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
                        <label class="form-label">Vehicle Registration Number</label>
                        <input type="text" name="vehicle_number" class="form-control text-uppercase" placeholder="e.g. MH-12-AB-1234" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">RFID / Parking Card Number</label>
                        <input type="text" name="card_number" class="form-control" placeholder="Unique Card ID" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assigned Date</label>
                        <input type="date" name="assigned_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Assign Parking Access</button>
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
                            <th>Vehicle No.</th>
                            <th>Card UUID</th>
                            <th>Date Assigned</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cards as $card)
                        <tr>
                            <td class="ps-3 fw-bold">
                                @if($card->employee)
                                {{ $card->employee->first_name }} {{ $card->employee->last_name }}
                                @else
                                <span class="text-danger">Deleted User</span>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ $card->vehicle_number }}</span></td>
                            <td class="font-monospace">{{ $card->card_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($card->assigned_date)->format('M d, Y') }}</td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.parking_cards.destroy', $card->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Revoke this parking access?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i> Revoke</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">No parking cards active.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($cards->hasPages())
            <div class="card-footer bg-white border-0 pt-3">
                {{ $cards->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
