@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.profile.show') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Profile</a>
    <h2 class="mt-2">Update Personal Details</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('employee.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $employee->phone) }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="alert alert-info">
                To update your name, email, or department information, please contact your Administrator.
            </div>

            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Save Changes</button>
        </form>
    </div>
</div>
@endsection
