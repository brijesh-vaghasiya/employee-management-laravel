<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASC Panel - Employee Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        
        body { font-family: 'Outfit', sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #1e1b4b, #4c1d95, #6d28d9); min-width: 260px; box-shadow: 4px 0 25px rgba(0,0,0,0.1); }
        .sidebar a { color: #e9d5ff; text-decoration: none; display: block; padding: 12px 20px; border-radius: 8px; margin: 4px 15px; transition: all 0.3s ease; font-weight: 500;}
        .sidebar a:hover { background: rgba(255, 255, 255, 0.1); color: #ffffff; transform: translateX(5px); }
        .sidebar a i { margin-right: 10px; }
        .main-content { padding: 20px; width: 100%; }
        
        .navbar { background: rgba(255, 255, 255, 0.9) !important; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05); border-radius: 12px; margin-bottom: 2rem !important; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); transition: all 0.3s ease; }
        .card:hover { box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); transform: translateY(-5px); }
        
        [data-bs-theme="dark"] body { background-color: #0f172a; color: #e2e8f0; }
        [data-bs-theme="dark"] .navbar, [data-bs-theme="dark"] .card { background-color: #1e293b !important; color: #f1f5f9; border: 1px solid rgba(255,255,255,0.05); }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        @auth
        <div class="sidebar text-white shadow" style="width: 250px;">
            <div class="p-3 text-center">
                <h5>ASC Admin Console</h5>
                <hr>
            </div>
            <a href="{{ route('asc.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <div class="px-3 py-2 text-uppercase small fw-bold text-light opacity-50 mt-2">Auditing</div>
            <a href="{{ route('asc.logs.login') }}"><i class="bi bi-door-open"></i> Login Logs</a>
            <a href="{{ route('asc.logs.system') }}"><i class="bi bi-journal-text"></i> System Logs</a>
            <div class="px-3 py-2 text-uppercase small fw-bold text-light opacity-50 mt-2">Architecture</div>
            <a href="{{ route('asc.projects.index') }}"><i class="bi bi-building"></i> Projects & Roles</a>
            <hr>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> Logout</a>
            <form id="logout-form" action="{{ route('asc.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        @endauth

        <div class="main-content flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Administration Services Console</span>
                </div>
            </nav>

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
