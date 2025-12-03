<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartHR - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #4849E8;
            --light-blue: #ABC4FF;
            --accent-yellow: #DDF344;
            --bg-white: #F5F9FF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background shapes */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 25s infinite ease-in-out;
        }

        .shape1 {
            width: 500px;
            height: 500px;
            background: var(--light-blue);
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }

        .shape2 {
            width: 400px;
            height: 400px;
            background: var(--primary-blue);
            bottom: -100px;
            right: -100px;
            animation-delay: 5s;
        }

        .shape3 {
            width: 350px;
            height: 350px;
            background: var(--accent-yellow);
            top: 50%;
            left: 50%;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            25% { transform: translate(50px, -50px) rotate(90deg) scale(1.1); }
            50% { transform: translate(-30px, 30px) rotate(180deg) scale(0.9); }
            75% { transform: translate(60px, 20px) rotate(270deg) scale(1.05); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 32px;
            box-shadow: 0 20px 60px rgba(72, 73, 232, 0.15);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            margin: 2rem;
            position: relative;
            z-index: 1;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #6366f1 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(221, 243, 68, 0.1), transparent);
            animation: shimmer 4s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .login-header h1 {
            margin: 0;
            font-size: 3rem;
            font-weight: 800;
            position: relative;
            z-index: 1;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .login-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.95;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }

        .login-body {
            display: flex;
            flex-wrap: wrap;
        }

        .login-section {
            flex: 1;
            min-width: 350px;
            padding: 3rem 2.5rem;
            position: relative;
            animation: fadeIn 1s ease-out;
        }

        .login-section:first-child::after {
            content: '';
            position: absolute;
            right: 0;
            top: 10%;
            height: 80%;
            width: 2px;
            background: linear-gradient(180deg, transparent, var(--light-blue), transparent);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .login-section h2 {
            color: var(--primary-blue);
            margin-bottom: 2rem;
            font-size: 1.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .icon-badge {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: linear-gradient(135deg, rgba(72, 73, 232, 0.1), rgba(171, 196, 255, 0.1));
        }

        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.9);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(72, 73, 232, 0.1);
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 3.25rem;
            color: var(--primary-blue);
            font-size: 1.1rem;
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-blue) 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 4px 16px rgba(72, 73, 232, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-login:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(72, 73, 232, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login i, .btn-login span {
            position: relative;
            z-index: 1;
        }

        .alert {
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            font-size: 0.95rem;
            border-left: 4px solid;
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-color: #ef4444;
        }

        /* Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: var(--primary-blue);
            border-radius: 50%;
            opacity: 0.4;
        }

        @media (max-width: 768px) {
            .login-section {
                min-width: 100%;
                padding: 2rem 1.5rem;
            }

            .login-section:first-child::after {
                display: none;
            }

            .login-header h1 {
                font-size: 2.25rem;
            }

            .login-header {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background -->
    <div class="bg-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
    </div>

    <!-- Floating particles -->
    <div class="particles" id="particles"></div>

    <div class="login-container">
        <div class="login-header">
            <h1><i class="bi bi-building"></i> SmartHR</h1>
            <p>Human Resources Management System</p>
        </div>

        <div class="login-body">
            <!-- Employee Login Section -->
            <div class="login-section">
                <h2>
                    <div class="icon-badge">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    Employee Login
                </h2>

                @if ($errors->has('username'))
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i> {{ $errors->first('username') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('employee.profile.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="emp-username">Username</label>
                        <i class="bi bi-person input-icon"></i>
                        <input 
                            type="text" 
                            id="emp-username" 
                            name="username" 
                            value="{{ old('username') }}"
                            required 
                            autofocus
                            placeholder="Enter your username">
                    </div>

                    <div class="form-group">
                        <label for="emp-password">Password</label>
                        <i class="bi bi-lock input-icon"></i>
                        <input 
                            type="password" 
                            id="emp-password" 
                            name="password" 
                            required
                            placeholder="Enter your password">
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Login as Employee</span>
                    </button>
                </form>
            </div>

            <!-- Admin Login Section -->
            <div class="login-section">
                <h2>
                    <div class="icon-badge">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    Admin Login
                </h2>

                @if ($errors->has('adminID'))
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i> {{ $errors->first('adminID') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="admin-id">Admin ID</label>
                        <i class="bi bi-person-badge input-icon"></i>
                        <input 
                            type="text" 
                            id="admin-id" 
                            name="adminID" 
                            value="{{ old('adminID') }}"
                            required
                            placeholder="Enter your admin ID">
                    </div>

                    <div class="form-group">
                        <label for="admin-password">Password</label>
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input 
                            type="password" 
                            id="admin-password" 
                            name="password" 
                            required
                            placeholder="Enter your password">
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-shield-check"></i>
                        <span>Login as Admin</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Generate floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 20;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animation = `float ${Math.random() * 20 + 15}s infinite ease-in-out ${Math.random() * 5}s`;
                particlesContainer.appendChild(particle);
            }
        }

        // Input focus animations
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        createParticles();
    </script>
</body>
</html>