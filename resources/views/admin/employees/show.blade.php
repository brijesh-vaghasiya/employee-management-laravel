@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('admin.employees.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Employees</a>
        <h2 class="mt-2">Employee Profile: {{ $employee->first_name }} {{ $employee->last_name }}</h2>
    </div>
    <div>
        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit Profile</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center py-5">
                <div class="display-1 text-muted mb-3"><i class="bi bi-person-circle"></i></div>
                <h4 class="card-title">{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                <p class="text-muted mb-1">{{ $employee->designation ?? 'N/A' }}</p>
                <p class="text-muted mb-3">{{ $employee->department ?? 'N/A' }}</p>
                <div>
                    @if($employee->is_active)
                        <span class="badge bg-success px-3 py-2">Active Employee</span>
                    @else
                        <span class="badge bg-danger px-3 py-2">Inactive Employee</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary">Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0 text-muted">Employee Code</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $employee->employee_code }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0 text-muted">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $employee->email }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0 text-muted">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $employee->phone ?? 'Not provided' }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0 text-muted">Joining Date</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('F d, Y') : 'Not defined' }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0 text-muted">Salary</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $employee->salary ? '$'.number_format($employee->salary, 2) : 'Not defined' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
