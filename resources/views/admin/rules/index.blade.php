@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Company Rules & Policies</h2>
    <a href="{{ route('admin.rules.create') }}" class="btn btn-primary"><i class="bi bi-file-earmark-text"></i> Add Policy</a>
</div>

<div class="row">
    @forelse($rules as $rule)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 border-0 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title text-primary">{{ $rule->title }}</h5>
                        <div>
                            <a href="{{ route('admin.rules.edit', $rule) }}" class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.rules.destroy', $rule) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this policy?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <p class="card-text text-muted mt-2" style="white-space: pre-wrap;">{{ $rule->description }}</p>
                </div>
                <div class="card-footer bg-white border-0 text-muted small pb-3">
                    Last updated: {{ $rule->updated_at->format('M d, Y') }}
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 py-5 text-center text-muted">
            No company rules or policies have been published yet.
        </div>
    @endforelse
</div>

@if($rules->hasPages())
<div class="d-flex justify-content-center mt-3">
    {{ $rules->links() }}
</div>
@endif
@endsection
