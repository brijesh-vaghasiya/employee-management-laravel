@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>T-Shirt Inventory</h2>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold">
                Add Stock
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tshirts.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Design Name / Edition</label>
                        <input type="text" name="design_name" class="form-control" placeholder="e.g. Annual 2026 Edition" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Size</label>
                        <select name="size" class="form-select" required>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                            <option value="XXXL">XXXL</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Available Stock</label>
                        <input type="number" name="stock" class="form-control" value="0" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Inventory Item</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Design Name</th>
                            <th>Size</th>
                            <th>Stock</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tshirts as $tshirt)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $tshirt->design_name }}</td>
                            <td><span class="badge bg-info">{{ $tshirt->size }}</span></td>
                            <td>
                                @if($tshirt->stock > 0)
                                    <span class="badge bg-success">{{ $tshirt->stock }} Available</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.tshirts.destroy', $tshirt->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this inventory item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No inventory records added.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($tshirts->hasPages())
            <div class="card-footer bg-white border-0 pt-3">
                {{ $tshirts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
