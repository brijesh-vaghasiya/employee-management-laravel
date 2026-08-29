@extends('layouts.asc')

@section('content')
<h2 class="mb-4">Administration Services Console (ASC)</h2>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Login Logs</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $loginCount }}</h2>
                    </div>
                    <div><i class="bi bi-door-open-fill display-4 opacity-50"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-danger shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase fw-bold opacity-75">System Activities</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $sysCount }}</h2>
                    </div>
                    <div><i class="bi bi-journal-check display-4 opacity-50"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-dark shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Total Projects</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $projectCount }}</h2>
                    </div>
                    <div><i class="bi bi-building display-4 opacity-50"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-door-open text-primary me-2"></i> Recent Logins
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentLogins as $log)
                    <li class="list-group-item px-4 py-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $log->email }}</h6>
                            <small class="text-muted">{{ $log->login_date ? \Carbon\Carbon::parse($log->login_date)->diffForHumans() : 'N/A' }}</small>
                        </div>
                        <p class="mb-1 small">
                            Role: <span class="badge bg-secondary">{{ $log->role }}</span>
                            @if($log->result == 'Success')
                                <span class="badge bg-success ms-1">Success</span>
                            @else
                                <span class="badge bg-danger ms-1">Failed</span>
                            @endif
                        </p>
                    </li>
                    @empty
                    <li class="list-group-item px-4 py-3 text-muted text-center">No login logs.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-journal-text text-danger me-2"></i> Recent System Activity
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentSystem as $log)
                    <li class="list-group-item px-4 py-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 text-danger">{{ $log->action }}</h6>
                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-0 small text-muted">{{ $log->description }}</p>
                    </li>
                    @empty
                    <li class="list-group-item px-4 py-3 text-muted text-center">No system logs.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
