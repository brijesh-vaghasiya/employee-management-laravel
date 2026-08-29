@extends('layouts.employee')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-primary">
            <div class="card-body">
                <h4 class="card-title text-primary">Welcome, {{ Auth::user()->name }}</h4>
                <p class="card-text">Employee Dashboard - Manage your timesheets, leaves, and requests.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Today's Timesheet overview -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark"><i class="bi bi-clock-history"></i> Today's Timesheet</h5>
                <span class="badge bg-secondary">{{ \Carbon\Carbon::now()->format('M d, Y') }}</span>
            </div>
            <div class="card-body text-center">
                @if(isset($todayTimesheet))
                    <div class="row mt-3">
                        <div class="col-6">
                            <h6 class="text-muted">Clock In</h6>
                            <h4 class="text-success">{{ $todayTimesheet->in_time ? \Carbon\Carbon::parse($todayTimesheet->in_time)->format('h:i A') : '--:--' }}</h4>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted">Clock Out</h6>
                            <h4 class="text-danger">{{ $todayTimesheet->out_time ? \Carbon\Carbon::parse($todayTimesheet->out_time)->format('h:i A') : '--:--' }}</h4>
                        </div>
                    </div>
                    
                    @if($todayTimesheet->in_time && !$todayTimesheet->out_time)
                        <hr>
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            @if(!$todayTimesheet->intermediate_start)
                                <form action="{{ route('employee.timesheets.startIntermediate') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-warning btn-sm"><i class="bi bi-cup-hot"></i> Start Break</button>
                                </form>
                            @elseif($todayTimesheet->intermediate_start && !$todayTimesheet->intermediate_end)
                                <form action="{{ route('employee.timesheets.endIntermediate') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-info btn-sm text-white"><i class="bi bi-play-fill"></i> Resume Work</button>
                                </form>
                            @endif
                            <form action="{{ route('employee.timesheets.clockOut') }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Clock Out Now</button>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="py-4">
                        <p class="text-muted mb-3">No timesheet record for today yet.</p>
                        <form action="{{ route('employee.timesheets.clockIn') }}" method="POST">
                            @csrf
                            <button class="btn btn-success"><i class="bi bi-box-arrow-in-right"></i> Clock In Now</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Active Leaves -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-dark"><i class="bi bi-calendar-check"></i> Active Leaves (Today)</h5>
            </div>
            <div class="card-body">
                @if(isset($activeLeaves) && count($activeLeaves) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($activeLeaves as $leave)
                            <li class="list-group-item px-0">
                                <span class="fw-bold">{{ $leave->leave_type }}</span> 
                                <span class="badge bg-success float-end">Approved</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">You are not on leave today.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!-- Upcoming Holidays -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100 border-start border-success border-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-dark"><i class="bi bi-gift text-success"></i> Upcoming Holidays</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($upcomingHolidays as $holiday)
                        <li class="list-group-item py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">{{ $holiday->name }}</span>
                                <span class="badge bg-success">{{ \Carbon\Carbon::parse($holiday->holiday_date)->format('M d') }}</span>
                            </div>
                            @if($holiday->description)
                            <p class="mb-0 mt-1 small text-muted">{{ $holiday->description }}</p>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item py-4 text-center text-muted">No upcoming holidays scheduled.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Upcoming Birthdays -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100 border-start border-warning border-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-dark"><i class="bi bi-balloon text-warning"></i> Upcoming Birthdays</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($upcomingBirthdays as $bdayEmp)
                        <li class="list-group-item py-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $bdayEmp->first_name }} {{ $bdayEmp->last_name }}</h6>
                                <small class="text-muted">{{ $bdayEmp->department ?? 'Colleague' }}</small>
                            </div>
                            <span class="badge bg-warning text-dark border"><i class="bi bi-calendar-event"></i> {{ $bdayEmp->next_birthday->format('M d') }}</span>
                        </li>
                    @empty
                        <li class="list-group-item py-4 text-center text-muted">No upcoming birthdays.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
@endsection


