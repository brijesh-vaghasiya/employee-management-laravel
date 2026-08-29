<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            overflow-x: hidden;
        }

        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 1;
            top: 0;
            left: 0;
        }

        .main-content {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .hero-title {
            font-weight: 800;
            background: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
            letter-spacing: -1px;
        }

        .portal-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1.5rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            text-decoration: none;
            display: block;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .portal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            transition: all 0.75s;
            z-index: 1;
        }

        .portal-card:hover::before {
            left: 200%;
        }

        .portal-card:hover {
            transform: translateY(-10px) scale(1.02);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .icon-wrapper {
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 25px;
            background: rgba(255,255,255,0.1);
            box-shadow: inset 0 0 20px rgba(255,255,255,0.05);
            transition: transform 0.3s;
        }
        
        .portal-card:hover .icon-wrapper {
            transform: rotateY(180deg);
        }

        .text-neon {
            color: #fff;
            text-shadow: 0 0 10px rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>

<div id="particles-js"></div>

<div class="main-content">
    <div class="container">
        <div class="row text-center justify-content-center mb-5">
            <div class="col-md-8">
                <h1 class="display-3 hero-title mb-3">NextGen LIMS</h1>
                <p class="lead text-white-50">Select an infrastructure gateway to authenticate your session and securely access your operational dashboard.</p>
            </div>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Employee Portal -->
            <div class="col-md-4">
                <a href="{{ route('employee.login') }}" class="portal-card p-5 text-center h-100">
                    <div class="icon-wrapper text-info mx-auto">
                        <i class="bi bi-person-badge fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-neon mb-3">Employee Space</h4>
                    <p class="text-white-50 small mb-0">Access Timesheets, Leaves, Asset Inventory, and Helpdesk options.</p>
                </a>
            </div>
            
            <!-- Administrator Portal -->
            <div class="col-md-4">
                <a href="{{ route('admin.login') }}" class="portal-card p-5 text-center h-100 text-decoration-none">
                    <div class="icon-wrapper text-danger mx-auto">
                        <i class="bi bi-shield-lock fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-neon mb-3">Admin Console</h4>
                    <p class="text-white-50 small mb-0">Manage Employee lifecycles, Payroll logic, Helpdesk Tickets, and System definitions.</p>
                </a>
            </div>
            
            <!-- ASC Portal -->
            <div class="col-md-4">
                <a href="{{ route('asc.login') }}" class="portal-card p-5 text-center h-100 text-decoration-none">
                    <div class="icon-wrapper text-warning mx-auto">
                        <i class="bi bi-hdd-network fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-neon mb-3">ASC Gateway</h4>
                    <p class="text-white-50 small mb-0">Super-Administrator endpoint for Auditing, Logs, and foundational Project structures.</p>
                </a>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col text-center">
                <p class="small text-white-50 mb-0">&copy; {{ date('Y') }} Enterprise Management Ecosystem. Powered by Laravel 12.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    particlesJS("particles-js", {
        "particles": {
            "number": { "value": 80, "density": { "enable": true, "value_area": 800 } },
            "color": { "value": "#ffffff" },
            "shape": { "type": "circle" },
            "opacity": { "value": 0.5, "random": false, "anim": { "enable": false } },
            "size": { "value": 3, "random": true, "anim": { "enable": false } },
            "line_linked": { "enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1 },
            "move": {
                "enable": true,
                "speed": 2,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": { "enable": false }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": { "enable": true, "mode": "grab" },
                "onclick": { "enable": true, "mode": "push" },
                "resize": true
            },
            "modes": {
                "grab": { "distance": 140, "line_linked": { "opacity": 1 } },
                "push": { "particles_nb": 4 }
            }
        },
        "retina_detect": true
    });
</script>
</body>
</html>
