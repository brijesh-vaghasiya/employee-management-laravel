@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.employees.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Employees</a>
    <h2 class="mt-2">Edit Employee: {{ $employee->first_name }} {{ $employee->last_name }}</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <h5 class="mb-3 text-primary">Login Information</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address (Username)</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $employee->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password <small class="text-muted">(Leave blank to keep current)</small></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr>

            <h5 class="mb-3 mt-4 text-primary">Personal Details</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Employee Code</label>
                    <input type="text" name="employee_code" class="form-control @error('employee_code') is-invalid @enderror" value="{{ old('employee_code', $employee->employee_code) }}" required>
                    @error('employee_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $employee->first_name) }}" required>
                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $employee->last_name) }}" required>
                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $employee->phone) }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $employee->designation) }}">
                    @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Department</label>
                    <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ old('department', $employee->department) }}">
                    @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Salary</label>
                    <input type="number" step="0.01" name="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary', $employee->salary) }}">
                    @error('salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Joining Date</label>
                    <input type="date" name="joining_date" class="form-control @error('joining_date') is-invalid @enderror" value="{{ old('joining_date', $employee->joining_date) }}">
                    @error('joining_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                        <option value="1" {{ old('is_active', $employee->is_active) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $employee->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-5"><i class="bi bi-save"></i> Update Employee</button>
            </div>
        </form>
    </div>
</div>
@endsection
