<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel - Employee Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        
        body { font-family: 'Outfit', sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #2563eb, #1e40af); min-width: 260px; box-shadow: 4px 0 25px rgba(0,0,0,0.1); }
        .sidebar a { color: #e0e7ff; text-decoration: none; display: block; padding: 12px 20px; border-radius: 8px; margin: 4px 15px; transition: all 0.3s ease; font-weight: 500;}
        .sidebar a:hover { background: rgba(255, 255, 255, 0.2); color: #ffffff; transform: translateX(5px); }
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
        <div class="sidebar text-white shadow">
            <div class="p-3 text-center">
                <h5>Employee Panel</h5>
                <hr>
            </div>
            <div class="px-3 py-2 text-uppercase small fw-bold text-light opacity-75">Core</div>
            <a href="{{ route('employee.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="{{ route('employee.calendar.index') }}"><i class="bi bi-calendar-range"></i> My Calendar</a>
            <a href="{{ route('employee.profile.show') }}"><i class="bi bi-person"></i> My Profile</a>
            <a href="{{ route('employee.tasks.index') }}"><i class="bi bi-list-task"></i> My Tasks</a>
            <a href="{{ route('employee.appraisals.index') }}"><i class="bi bi-award"></i> My Appraisals</a>
            <a href="{{ route('employee.tickets.index') }}"><i class="bi bi-headset"></i> IT & Support Tickets</a>
            <a href="{{ route('employee.daily_reports.index') }}"><i class="bi bi-journal-check"></i> My Daily EOD Reports</a>
            <a href="{{ route('employee.timesheets.index') }}"><i class="bi bi-clock-history"></i> Timesheet</a>
            <a href="{{ route('employee.payslips.index') }}"><i class="bi bi-receipt"></i> My Payslips</a>
            <a href="{{ route('employee.expense_claims.index') }}"><i class="bi bi-cash-stack"></i> Expense Claims</a>
            <a href="{{ route('employee.leaves.index') }}"><i class="bi bi-calendar-event"></i> Leaves</a>
            <a href="{{ route('employee.documents.index') }}"><i class="bi bi-file-earmark-text"></i> My Documents</a>
            <hr>
            <div class="px-3 py-2 text-uppercase small fw-bold text-light opacity-75">Organization</div>
            <a href="{{ route('employee.assets.index') }}"><i class="bi bi-box-seam"></i> My Assets</a>
            <a href="{{ route('employee.requests.index') }}"><i class="bi bi-ticket-detailed"></i> Helpdesk Tickets</a>
            <hr>
            <div class="d-flex align-items-center px-3">
                <button class="btn btn-link text-white me-3" id="theme-toggle" title="Toggle Dark/Light Mode">
                    <i class="bi bi-moon-stars-fill fs-5"></i>
                </button>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white text-decoration-none">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
            <form id="logout-form" action="{{ route('employee.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        @endauth

        <div class="main-content flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Employee Dashboard</span>
                </div>
            </nav>

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session("success") }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session("error") }}'
            });
        @endif
    </script>
    <script>
        // Dark Mode Logic
        document.addEventListener('DOMContentLoaded', () => {
            const getStoredTheme = () => localStorage.getItem('theme');
            const setStoredTheme = theme => localStorage.setItem('theme', theme);
            const setTheme = theme => {
                document.documentElement.setAttribute('data-bs-theme', theme)
            }
            
            let currentTheme = getStoredTheme() || 'light';
            setTheme(currentTheme);

            const toggleBtn = document.getElementById('theme-toggle');
            if(toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    const newTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                    setTheme(newTheme);
                    setStoredTheme(newTheme);
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
