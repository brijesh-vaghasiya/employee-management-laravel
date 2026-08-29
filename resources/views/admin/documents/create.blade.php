@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.documents.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Documents</a>
    <h2 class="mt-2">{{ isset($document) ? 'Edit Document Format' : 'Add Document Format' }}</h2>
</div>

<div class="card shadow-sm border-0" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ isset($document) ? route('admin.documents.update', $document) : route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($document)) @method('PUT') @endif
            
            <div class="mb-3">
                <label class="form-label">Document Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $document->name ?? '') }}" required placeholder="e.g. Offer Letter, NDA">
            </div>

            <div class="mb-3">
                <label class="form-label">Format Type</label>
                <input type="text" name="format_type" class="form-control" value="{{ old('format_type', $document->format_type ?? '') }}" required placeholder="e.g. PDF Template, Word Doc">
            </div>

            <div class="mb-4">
                <label class="form-label">Upload File Attachment</label>
                <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.txt">
                @if(isset($document) && $document->file_path)
                    <small class="text-muted d-block mt-2">Current file: <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">View</a></small>
                @endif
            </div>

            <button type="submit" class="btn btn-primary px-4">{{ isset($document) ? 'Update Format' : 'Save Format' }}</button>
        </form>
    </div>
</div>
@endsection

