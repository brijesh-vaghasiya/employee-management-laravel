@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <a href="{{ route('employee.profile.show') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Profile</a>
    <h2 class="mt-2">Change Password</h2>
</div>

<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('employee.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary px-4">Update Password</button>
        </form>
    </div>
</div>
@endsection
