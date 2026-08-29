@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary h-100">
            <div class="card-body">
                <h5 class="card-title">Total Employees</h5>
                <h2 class="display-4"><span class="counter" data-target="{{ $totalEmployees ?? 0 }}">0</span></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <h5 class="card-title">Active Employees</h5>
                <h2 class="display-4"><span class="counter" data-target="{{ $activeEmployees ?? 0 }}">0</span></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning h-100">
            <div class="card-body">
                <h5 class="card-title text-dark">Pending Leaves</h5>
                <h2 class="display-4 text-dark"><span class="counter" data-target="{{ $pendingLeaves ?? 0 }}">0</span></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-dark stretched-link" href="#">View Details</a>
                <div class="small text-dark"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info h-100">
            <div class="card-body">
                <h5 class="card-title">Upcoming Birthdays</h5>
                <h2 class="display-4"><span class="counter" data-target="{{ $upcomingBirthdays ?? 0 }}">0</span></h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('.counter');
        const speed = 200; 

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    });
</script>
@endpush
