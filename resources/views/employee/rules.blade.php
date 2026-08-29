@extends('layouts.employee')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2>Company Rules & Policies</h2>
    </div>
</div>

<div class="row">
    @forelse($rules as $rule)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 border-0 border-start border-info border-4">
                <div class="card-body">
                    <h5 class="card-title text-info fw-bold">{{ $rule->title }}</h5>
                    <p class="card-text text-muted mt-3" style="white-space: pre-wrap;">{{ $rule->description }}</p>
                </div>
                <div class="card-footer bg-white border-0 text-muted small pb-3">
                    Last updated: {{ $rule->updated_at->format('M d, Y') }}
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="bi bi-info-circle fs-3 d-block mb-3"></i>
            No official company rules or policies have been published yet.
        </div>
    @endforelse
</div>
@endsection
