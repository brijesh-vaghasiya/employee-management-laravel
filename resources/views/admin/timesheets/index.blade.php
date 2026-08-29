@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Timesheet Management</h2>
</div>

<div class="card shadow-sm mb-4 border-0">
    <div class="card-body bg-light rounded">
        <form action="{{ route('admin.timesheets.index') }}" method="GET" class="row gx-3 gy-2 align-items-center">
            
            <div class="col-sm-3">
                <label class="visually-hidden" for="employee_id">Employee</label>
                <select class="form-select" id="employee_id" name="employee_id">
                    <option value="">All Employees...</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->employee_code }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-sm-3">
                <label class="visually-hidden" for="date_from">Date From</label>
                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}" placeholder="Date From">
            </div>
            
            <div class="col-sm-3">
                <label class="visually-hidden" for="date_to">Date To</label>
                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}" placeholder="Date To">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter Records</button>
                <a href="{{ route('admin.timesheets.index') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Employee</th>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Break Start</th>
                        <th>Break End</th>
                        <th>Clock Out</th>
                        <th>Worked Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($timesheets as $timesheet)
                    <tr>
                        <td class="ps-3 fw-bold">
                            @if($timesheet->employee)
                                {{ $timesheet->employee->first_name }} {{ $timesheet->employee->last_name }} <br>
                                <small class="text-muted">{{ $timesheet->employee->employee_code }}</small>
                            @else
                                <span class="text-danger">Deleted Employee</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($timesheet->date)->format('M d, Y') }}</td>
                        <td>
                            <span class="{{ $timesheet->in_time ? 'text-success fw-bold' : '' }}">
                                {{ $timesheet->in_time ? \Carbon\Carbon::parse($timesheet->in_time)->format('h:i A') : '--' }}
                            </span>
                            @if($timesheet->reason_late) 
                                <br><small class="text-muted" title="{{ $timesheet->reason_late }}"><i class="bi bi-info-circle"></i> Late Note</small> 
                            @endif
                        </td>
                        <td>{{ $timesheet->intermediate_start ? \Carbon\Carbon::parse($timesheet->intermediate_start)->format('h:i A') : '--' }}</td>
                        <td>{{ $timesheet->intermediate_end ? \Carbon\Carbon::parse($timesheet->intermediate_end)->format('h:i A') : '--' }}</td>
                        <td>
                            <span class="{{ $timesheet->out_time ? 'text-danger fw-bold' : '' }}">
                                {{ $timesheet->out_time ? \Carbon\Carbon::parse($timesheet->out_time)->format('h:i A') : '--' }}
                            </span>
                        </td>
                        <td>
                            @if($timesheet->worked_hours)
                                <span class="badge bg-primary p-2 fs-6">{{ $timesheet->worked_hours }} hrs</span>
                            @else
                                <span class="badge bg-light text-dark p-2 border">Active Shift</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No timesheet records found for the given criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($timesheets->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $timesheets->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
