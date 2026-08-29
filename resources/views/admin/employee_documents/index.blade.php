@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Issued Documents</h2>
    <a href="{{ route('admin.employee_documents.create') }}" class="btn btn-primary"><i class="bi bi-person-lines-fill"></i> Issue Document to Employee</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Employee</th>
                        <th>Document</th>
                        <th>Assigned Date</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employeeDocuments as $ed)
                    <tr>
                        <td class="ps-3 fw-bold">
                            @if($ed->employee)
                                {{ $ed->employee->first_name }} {{ $ed->employee->last_name }} 
                                <div class="small text-muted">{{ $ed->employee->employee_code }}</div>
                            @else
                                <span class="text-danger">Deleted</span>
                            @endif
                        </td>
                        <td>
                            @if($ed->document)
                                <div class="fw-bold">{{ $ed->document->name }}</div>
                                <span class="badge bg-secondary">{{ $ed->document->format_type }}</span>
                                @if($ed->document->file_path)
                                    <a href="{{ route('secure.download', ['path' => $ed->document->file_path]) }}" target="_blank" class="btn btn-sm btn-link text-info ms-2 px-0"><i class="bi bi-download"></i></a>
                                @endif
                            @else
                                <span class="text-danger">Document Deleted</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($ed->assigned_date)->format('M d, Y') }}</td>
                        <td class="text-end pe-3">
                            <form action="{{ route('admin.employee_documents.destroy', $ed->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Revoke this document from the employee?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i> Revoke</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No documents have been issued to employees yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($employeeDocuments->hasPages())
    <div class="card-footer bg-white pt-3 border-0">
        {{ $employeeDocuments->links() }}
    </div>
    @endif
</div>
@endsection
