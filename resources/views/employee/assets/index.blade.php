@extends('layouts.employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Assets</h2>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-dark text-white fw-bold">
                <i class="bi bi-box-seam me-2"></i> Assigned T-Shirts
            </div>
            <div class="card-body">
                @if($tshirts->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($tshirts as $assign)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $assign->tshirt->design_name ?? 'Deleted Design' }}</h6>
                                <small class="text-muted">Assigned on: {{ \Carbon\Carbon::parse($assign->assigned_date)->format('M d, Y') }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill fs-6 px-3">Size: {{ $assign->tshirt->size ?? 'N/A' }}</span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-emoji-frown display-4 opacity-50 mb-3 d-block"></i>
                        No T-Shirts assigned to you yet.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-dark text-white fw-bold">
                <i class="bi bi-p-square me-2"></i> Parking Access Cards
            </div>
            <div class="card-body">
                @if($parkingCards->count() > 0)
                    <div class="row g-3">
                        @foreach($parkingCards as $card)
                        <div class="col-12">
                            <div class="border rounded p-3 position-relative overflow-hidden bg-light">
                                <div class="position-absolute end-0 top-0 h-100 w-25 bg-secondary opacity-10" style="transform: skew(-20deg);"></div>
                                <h6 class="text-uppercase text-muted small fw-bold mb-1">Vehicle Plate</h6>
                                <h4 class="fw-bold mb-3">{{ $card->vehicle_number }}</h4>
                                
                                <h6 class="text-uppercase text-muted small fw-bold mb-1">Pass Card ID</h6>
                                <p class="font-monospace fs-5 mb-0 text-primary">{{ $card->card_number }}</p>

                                <div class="mt-3 pd-2 border-top">
                                    <small class="text-muted">Valid Since: {{ \Carbon\Carbon::parse($card->assigned_date)->format('M d, Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-car-front display-4 opacity-50 mb-3 d-block"></i>
                        No parking access cards assigned.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
