<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASC Gateway | LIMS</title>
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
            background: linear-gradient(135deg, #09090b, #18181b, #27272a);
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 1;
            top: 0;
            left: 0;
        }

        .login-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1.5rem;
            box-shadow: 0 25px 45px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: rgba(255,255,255,0.05);
            box-shadow: inset 0 0 20px rgba(255,255,255,0.02);
            color: #d8b4fe;
        }

        .form-control {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            border-radius: 10px;
            padding: 12px 15px;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.1);
            border-color: #d8b4fe;
            color: #fff;
            box-shadow: 0 0 15px rgba(216, 180, 254, 0.3);
        }
        
        .form-control::placeholder {
            color: rgba(255,255,255,0.4);
        }

        .form-label {
            color: #e2e8f0;
            font-weight: 500;
        }
        
        .hero-title {
            font-weight: 800;
            color: #fff;
            text-shadow: 0 0 15px rgba(255,255,255,0.2);
        }

        .btn-portal {
            background: linear-gradient(45deg, #7e22ce, #a855f7);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-portal:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(168, 85, 247, 0.4);
        }

        .auth-error {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff8787;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>

    <div class="login-container">
        <div class="login-card p-5">
            <div class="text-center mb-4">
                <div class="icon-wrapper">
                    <i class="bi bi-hdd-network fs-2"></i>
                </div>
                <h3 class="hero-title">ASC Gateway</h3>
                <p class="text-white-50 small mb-0">Authorized Super-Admin Protocol</p>
            </div>

            @if ($errors->any())
                <div class="auth-error p-3 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li class="small fw-semibold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('asc.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">System Admin Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="root@lims.sys" required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Security Key</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-portal w-100 mb-3">Execute Protocol</button>
                <div class="text-center">
                    <a href="{{ url('/') }}" class="text-white-50 small text-decoration-none hover-white"><i class="bi bi-arrow-left"></i> Terminate Protocol</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 100, "density": { "enable": true, "value_area": 800 } },
                "color": { "value": "#d8b4fe" },
                "shape": { "type": "edge" },
                "opacity": { "value": 0.2, "random": true },
                "size": { "value": 2, "random": true },
                "line_linked": { "enable": true, "distance": 120, "color": "#d8b4fe", "opacity": 0.1, "width": 1 },
                "move": { "enable": true, "speed": 1, "direction": "none", "random": true, "out_mode": "out" }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": { "enable": true, "mode": "repulse" },
                    "onclick": { "enable": true, "mode": "push" }
                },
                "modes": {
                    "repulse": { "distance": 100, "duration": 0.4 },
                    "push": { "particles_nb": 4 }
                }
            },
            "retina_detect": true
        });
    </script>
</body>
</html>
