@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.employee_documents.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Issued Documents</a>
    <h2 class="mt-2">Issue Document to Employee</h2>
</div>

<div class="card shadow-sm border-0" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.employee_documents.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Select Employee</label>
                <select name="employee_id" class="form-select select2" required>
                    <option value="" disabled selected>Choose an employee...</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->employee_code }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Document Format</label>
                <select name="document_id" class="form-select select2" required>
                    <option value="" disabled selected>Choose a document...</option>
                    @foreach($documents as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->format_type }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Assigned Date</label>
                <input type="date" name="assigned_date" class="form-control" value="{{ old('assigned_date', \Carbon\Carbon::today()->format('Y-m-d')) }}" required>
            </div>

            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-person-check-fill"></i> Issue Document</button>
        </form>
    </div>
</div>
@endsection
