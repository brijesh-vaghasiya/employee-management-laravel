@extends('layouts.employee')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center py-5">
                <div class="display-1 text-muted mb-3"><i class="bi bi-person-circle"></i></div>
                <h4 class="card-title">{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                <p class="text-muted mb-1">{{ $employee->designation ?? 'N/A' }}</p>
                <p class="text-muted mb-3">{{ $employee->department ?? 'N/A' }}</p>
                <a href="{{ route('employee.profile.edit') }}" class="btn btn-outline-primary mt-2">Edit Details</a>
                <a href="{{ route('employee.password.change') }}" class="btn btn-outline-secondary mt-2">Change Password</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary">Your Information</h5>
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
                        <small class="text-muted ms-2">(Contact Admin to change)</small>
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
            </div>
        </div>
    </div>
</div>
@endsection
