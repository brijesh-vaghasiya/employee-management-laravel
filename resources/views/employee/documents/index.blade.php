@extends('layouts.employee')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2>My Documents</h2>
        <p class="text-muted">Access official documents and formats assigned to you.</p>
    </div>
</div>

<div class="row">
    @forelse($myDocuments as $myDoc)
        @if($myDoc->document)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 border-0 border-top border-primary border-4">
                    <div class="card-body text-center py-4">
                        <div class="display-4 text-primary mb-3">
                            @if(Str::contains(strtolower($myDoc->document->format_type), 'pdf'))
                                <i class="bi bi-file-earmark-pdf"></i>
                            @elseif(Str::contains(strtolower($myDoc->document->format_type), 'word') || Str::contains(strtolower($myDoc->document->format_type), 'doc'))
                                <i class="bi bi-file-earmark-word"></i>
                            @else
                                <i class="bi bi-file-earmark-text"></i>
                            @endif
                        </div>
                        <h5 class="card-title fw-bold text-dark mb-1">{{ $myDoc->document->name }}</h5>
                        <p class="small text-muted mb-3">{{ $myDoc->document->format_type }}</p>
                        
                        @if($myDoc->document->file_path)
                            <a href="{{ route('secure.download', ['path' => $myDoc->document->file_path]) }}" target="_blank" class="btn btn-outline-primary btn-sm px-4 rounded-pill">
                                <i class="bi bi-cloud-download me-1"></i> Download / View
                            </a>
                        @else
                            <button class="btn btn-outline-secondary btn-sm px-4 rounded-pill" disabled>No File Attached</button>
                        @endif
                    </div>
                    <div class="card-footer bg-light border-0 text-center small text-muted">
                        Assigned: {{ \Carbon\Carbon::parse($myDoc->assigned_date)->format('M d, Y') }}
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="col-12 py-5 text-center text-muted">
            <i class="bi bi-folder2-open display-1 d-block mb-3 text-secondary opacity-50"></i>
            <h4>No Documents Found</h4>
            <p>You have not been assigned any official documents yet.</p>
        </div>
    @endforelse
</div>

@if($myDocuments->hasPages())
<div class="d-flex justify-content-center mt-3">
    {{ $myDocuments->links() }}
</div>
@endif
@endsection
