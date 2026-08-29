@extends('layouts.employee')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2>My Timesheets</h2>
        <span class="badge bg-primary fs-5">{{ \Carbon\Carbon::now()->format('F d, Y') }}</span>
    </div>
</div>

<!-- Clock Actions Card -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title text-center mb-4">Today's Clock Actions</h5>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            
            @if(!$todayTimesheet || !$todayTimesheet->in_time)
                <!-- Can Clock In -->
                <form action="{{ route('employee.timesheets.clockIn') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm"><i class="bi bi-box-arrow-in-right"></i> Clock In</button>
                    <!-- Missing late reason input for simplicity; can be added in a modal -->
                </form>
            @else
                
                @if(!$todayTimesheet->out_time)
                    <!-- Can Start Break / End Break -->
                    @if(!$todayTimesheet->intermediate_start)
                        <!-- Hasn't taken break yet -->
                        <form action="{{ route('employee.timesheets.startIntermediate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-lg px-5 shadow-sm"><i class="bi bi-cup-hot"></i> Start Break</button>
                        </form>
                    @elseif($todayTimesheet->intermediate_start && !$todayTimesheet->intermediate_end)
                        <!-- On break, needs to end it -->
                        <form action="{{ route('employee.timesheets.endIntermediate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info btn-lg px-5 shadow-sm text-white"><i class="bi bi-play-fill"></i> End Break</button>
                        </form>
                    @endif

                    <!-- Can Clock Out -->
                    <form action="{{ route('employee.timesheets.clockOut') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg px-5 shadow-sm"><i class="bi bi-box-arrow-left"></i> Clock Out</button>
                    </form>
                @else
                    <div class="alert alert-secondary mb-0 w-100 text-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 d-block mb-2"></i>
                        You have completed your shift for today. Total worked hours: <strong>{{ $todayTimesheet->worked_hours }}</strong>
                    </div>
                @endif
                
            @endif
            
        </div>
        
        <!-- Status summary for today -->
        @if($todayTimesheet)
        <hr class="mt-4">
        <div class="row text-center mt-3">
            <div class="col-md-3">
                <small class="text-muted d-block">Clock In</small>
                <span class="fs-5 text-success fw-bold">{{ $todayTimesheet->in_time ? \Carbon\Carbon::parse($todayTimesheet->in_time)->format('h:i A') : '--' }}</span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Break Start</small>
                <span class="fs-5 text-warning fw-bold">{{ $todayTimesheet->intermediate_start ? \Carbon\Carbon::parse($todayTimesheet->intermediate_start)->format('h:i A') : '--' }}</span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Break End</small>
                <span class="fs-5 text-info fw-bold">{{ $todayTimesheet->intermediate_end ? \Carbon\Carbon::parse($todayTimesheet->intermediate_end)->format('h:i A') : '--' }}</span>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Clock Out</small>
                <span class="fs-5 text-danger fw-bold">{{ $todayTimesheet->out_time ? \Carbon\Carbon::parse($todayTimesheet->out_time)->format('h:i A') : '--' }}</span>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- History Card -->
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-primary">Timesheet History</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle z-table">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Break Start</th>
                        <th>Break End</th>
                        <th>Clock Out</th>
                        <th>Worked Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($timesheets as $timesheet)
                    <tr>
                        <td class="fw-bold">{{ \Carbon\Carbon::parse($timesheet->date)->format('M d, Y') }}</td>
                        <td>{{ $timesheet->in_time ? \Carbon\Carbon::parse($timesheet->in_time)->format('h:i A') : '--' }}</td>
                        <td>{{ $timesheet->intermediate_start ? \Carbon\Carbon::parse($timesheet->intermediate_start)->format('h:i A') : '--' }}</td>
                        <td>{{ $timesheet->intermediate_end ? \Carbon\Carbon::parse($timesheet->intermediate_end)->format('h:i A') : '--' }}</td>
                        <td>{{ $timesheet->out_time ? \Carbon\Carbon::parse($timesheet->out_time)->format('h:i A') : '--' }}</td>
                        <td>
                            @if($timesheet->worked_hours)
                                <span class="badge bg-secondary p-2">{{ $timesheet->worked_hours }} hrs</span>
                            @else
                                <span class="badge bg-light text-muted p-2">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No timesheet records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $timesheets->links() }}
        </div>
    </div>
</div>
@endsection
