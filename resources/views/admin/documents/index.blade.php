@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Document Formats</h2>
    <a href="{{ route('admin.documents.create') }}" class="btn btn-primary"><i class="bi bi-file-earmark-plus"></i> Add Document Format</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Document Name</th>
                        <th>Format Type</th>
                        <th>File Attachment</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <td class="ps-3 fw-bold">{{ $doc->name }}</td>
                        <td>{{ $doc->format_type }}</td>
                        <td>
                            @if($doc->file_path)
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-download"></i> View File</a>
                            @else
                                <span class="text-muted small">No file uploaded</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.documents.edit', $doc) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.documents.destroy', $doc) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this document format?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No document formats found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($documents->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $documents->links() }}
    </div>
    @endif
</div>
@endsection
