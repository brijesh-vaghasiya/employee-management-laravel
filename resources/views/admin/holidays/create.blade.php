@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.holidays.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Holidays</a>
    <h2 class="mt-2">{{ isset($holiday) ? 'Edit Holiday' : 'Add New Holiday' }}</h2>
</div>

<div class="card shadow-sm border-0" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ isset($holiday) ? route('admin.holidays.update', $holiday) : route('admin.holidays.store') }}" method="POST">
            @csrf
            @if(isset($holiday)) @method('PUT') @endif
            
            <div class="mb-3">
                <label class="form-label">Holiday Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $holiday->name ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Holiday Date</label>
                <input type="date" name="holiday_date" class="form-control" value="{{ old('holiday_date', isset($holiday) ? $holiday->holiday_date : '') }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Description (Optional)</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $holiday->description ?? '') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary px-4">{{ isset($holiday) ? 'Update Holiday' : 'Save Holiday' }}</button>
        </form>
    </div>
</div>
@endsection

