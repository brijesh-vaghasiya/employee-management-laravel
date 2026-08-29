@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.rules.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Rules</a>
    <h2 class="mt-2">{{ isset($rule) ? 'Edit Policy' : 'Add New Policy' }}</h2>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ isset($rule) ? route('admin.rules.update', $rule) : route('admin.rules.store') }}" method="POST">
            @csrf
            @if(isset($rule)) @method('PUT') @endif
            
            <div class="mb-3">
                <label class="form-label">Policy Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $rule->title ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Detailed Policy Description</label>
                <textarea name="description" class="form-control" rows="10" required placeholder="Write the full policy here...">{{ old('description', $rule->description ?? '') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary px-4">{{ isset($rule) ? 'Update Policy' : 'Save Policy' }}</button>
        </form>
    </div>
</div>
@endsection

