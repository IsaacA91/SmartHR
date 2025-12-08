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
            --deep-purple: #6366f1;
            --soft-pink: #f0abfc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--bg-white) 0%, #e0e7ff 50%, var(--bg-white) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated gradient background */
        .bg-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, #ABC4FF, #4849E8, #DDF344, #6366f1, #ABC4FF);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            opacity: 0.15;
            z-index: 0;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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
            opacity: 0.5;
            animation: float 25s infinite ease-in-out;
        }

        .shape1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, var(--light-blue), var(--primary-blue));
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .shape2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, var(--primary-blue), var(--deep-purple));
            bottom: -150px;
            right: -150px;
            animation-delay: 5s;
        }

        .shape3 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, var(--accent-yellow), #a3e635);
            top: 40%;
            left: 60%;
            animation-delay: 10s;
        }

        .shape4 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, var(--soft-pink), var(--light-blue));
            top: 60%;
            left: 10%;
            animation-delay: 15s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            25% { transform: translate(80px, -80px) rotate(90deg) scale(1.15); }
            50% { transform: translate(-50px, 50px) rotate(180deg) scale(0.85); }
            75% { transform: translate(100px, 30px) rotate(270deg) scale(1.1); }
        }

        /* Floating orbs */
        .orbs {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            animation: orbFloat 20s infinite ease-in-out;
        }

        .orb:nth-child(1) {
            width: 20px;
            height: 20px;
            background: var(--accent-yellow);
            top: 20%;
            left: 10%;
            animation-delay: 0s;
            box-shadow: 0 0 30px var(--accent-yellow);
        }

        .orb:nth-child(2) {
            width: 15px;
            height: 15px;
            background: var(--primary-blue);
            top: 70%;
            left: 80%;
            animation-delay: 3s;
            box-shadow: 0 0 25px var(--primary-blue);
        }

        .orb:nth-child(3) {
            width: 25px;
            height: 25px;
            background: var(--light-blue);
            top: 40%;
            left: 90%;
            animation-delay: 6s;
            box-shadow: 0 0 35px var(--light-blue);
        }

        .orb:nth-child(4) {
            width: 18px;
            height: 18px;
            background: var(--deep-purple);
            top: 80%;
            left: 20%;
            animation-delay: 9s;
            box-shadow: 0 0 28px var(--deep-purple);
        }

        .orb:nth-child(5) {
            width: 12px;
            height: 12px;
            background: var(--accent-yellow);
            top: 10%;
            left: 70%;
            animation-delay: 12s;
            box-shadow: 0 0 20px var(--accent-yellow);
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.8; }
            25% { transform: translate(100px, -50px) scale(1.2); opacity: 1; }
            50% { transform: translate(-50px, 100px) scale(0.8); opacity: 0.6; }
            75% { transform: translate(80px, 50px) scale(1.1); opacity: 0.9; }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(25px);
            border: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 32px;
            box-shadow: 
                0 25px 80px rgba(72, 73, 232, 0.2),
                0 10px 40px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            margin: 2rem;
            position: relative;
            z-index: 1;
            animation: slideUp 0.8s ease-out, pulse 4s ease-in-out infinite;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(60px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 25px 80px rgba(72, 73, 232, 0.2), 0 10px 40px rgba(0, 0, 0, 0.1); }
            50% { box-shadow: 0 30px 100px rgba(72, 73, 232, 0.3), 0 15px 50px rgba(0, 0, 0, 0.12); }
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--deep-purple) 50%, #8b5cf6 100%);
            color: white;
            padding: 3.5rem 2rem;
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
            background: linear-gradient(45deg, transparent, rgba(221, 243, 68, 0.15), transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite linear;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-yellow), var(--light-blue), var(--accent-yellow));
            background-size: 200% 100%;
            animation: borderGlow 3s linear infinite;
        }

        @keyframes borderGlow {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .login-header h1 {
            margin: 0;
            font-size: 3.2rem;
            font-weight: 800;
            position: relative;
            z-index: 1;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            letter-spacing: -1px;
        }

        .login-header h1 i {
            display: inline-block;
            animation: iconBounce 2s ease-in-out infinite;
            margin-right: 0.5rem;
        }

        @keyframes iconBounce {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-5px) rotate(-5deg); }
            75% { transform: translateY(-3px) rotate(5deg); }
        }

        .login-header p {
            margin: 0.75rem 0 0 0;
            opacity: 0.95;
            font-size: 1.15rem;
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
            animation: fadeInUp 1s ease-out;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(171, 196, 255, 0.05) 100%);
        }

        .login-section:nth-child(1) {
            animation-delay: 0.2s;
        }

        .login-section:nth-child(2) {
            animation-delay: 0.4s;
        }

        .login-section:first-child::after {
            content: '';
            position: absolute;
            right: 0;
            top: 10%;
            height: 80%;
            width: 3px;
            background: linear-gradient(180deg, transparent, var(--accent-yellow), var(--primary-blue), var(--accent-yellow), transparent);
            border-radius: 2px;
        }

        @keyframes fadeInUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
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
            width: 55px;
            height: 55px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            background: linear-gradient(135deg, var(--primary-blue), var(--deep-purple));
            color: white;
            box-shadow: 0 8px 20px rgba(72, 73, 232, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .login-section:hover .icon-badge {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 30px rgba(72, 73, 232, 0.4);
        }

        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
            transition: all 0.3s ease;
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
            transition: all 0.3s ease;
        }

        .form-group:focus-within label {
            color: var(--primary-blue);
        }

        .form-group input {
            width: 100%;
            padding: 1.1rem 1rem 1.1rem 3.2rem;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, rgba(245, 249, 255, 1) 100%);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 
                0 0 0 4px rgba(72, 73, 232, 0.1),
                0 8px 25px rgba(72, 73, 232, 0.15);
            transform: translateY(-3px);
            background: white;
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        .input-icon {
            position: absolute;
            left: 1.1rem;
            top: 3.35rem;
            color: var(--light-blue);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .form-group:focus-within .input-icon {
            color: var(--primary-blue);
            transform: scale(1.1);
        }

        .btn-login {
            width: 100%;
            padding: 1.15rem;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--deep-purple) 50%, #8b5cf6 100%);
            background-size: 200% 200%;
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 6px 20px rgba(72, 73, 232, 0.35);
            position: relative;
            overflow: hidden;
            animation: gradientMove 3s ease infinite;
        }

        @keyframes gradientMove {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
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

        .btn-login::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::after {
            left: 100%;
        }

        .btn-login:hover::before {
            width: 500px;
            height: 500px;
        }

        .btn-login:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 35px rgba(72, 73, 232, 0.45);
        }

        .btn-login:active {
            transform: translateY(-2px) scale(1.01);
        }

        .btn-login i, .btn-login span {
            position: relative;
            z-index: 1;
        }

        .btn-login i {
            transition: transform 0.3s ease;
        }

        .btn-login:hover i {
            transform: translateX(5px);
        }

        .alert {
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
            border-radius: 14px;
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
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
            color: #dc2626;
            border-color: #ef4444;
            backdrop-filter: blur(10px);
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
            border-radius: 50%;
            opacity: 0.6;
            animation: particleFloat 15s infinite ease-in-out;
        }

        @keyframes particleFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.6; }
            25% { transform: translate(50px, -80px) rotate(90deg); opacity: 0.8; }
            50% { transform: translate(-30px, -120px) rotate(180deg); opacity: 0.4; }
            75% { transform: translate(80px, -60px) rotate(270deg); opacity: 0.7; }
        }

        /* Confetti-like sparkles */
        .sparkle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: var(--accent-yellow);
            border-radius: 50%;
            pointer-events: none;
            animation: sparkleAnim 4s infinite ease-in-out;
        }

        @keyframes sparkleAnim {
            0%, 100% { opacity: 0; transform: scale(0); }
            50% { opacity: 1; transform: scale(1); }
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

            .shape {
                opacity: 0.3;
            }
        }
    </style>
</head>
<body>
    <!-- Animated gradient background -->
    <div class="bg-gradient"></div>

    <!-- Animated background shapes -->
    <div class="bg-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
        <div class="shape shape4"></div>
    </div>

    <!-- Floating orbs -->
    <div class="orbs">
        <div class="orb"></div>
        <div class="orb"></div>
        <div class="orb"></div>
        <div class="orb"></div>
        <div class="orb"></div>
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

                <form method="POST" action="{{ route('employee.login') }}">
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
        // Generate floating particles with variety
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 30;
            const colors = ['#4849E8', '#ABC4FF', '#DDF344', '#6366f1', '#f0abfc'];
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = (Math.random() * 100 + 100) + '%';
                particle.style.width = (Math.random() * 6 + 2) + 'px';
                particle.style.height = particle.style.width;
                particle.style.background = colors[Math.floor(Math.random() * colors.length)];
                particle.style.animationDuration = (Math.random() * 15 + 10) + 's';
                particle.style.animationDelay = (Math.random() * 5) + 's';
                particle.style.boxShadow = `0 0 ${Math.random() * 10 + 5}px ${particle.style.background}`;
                particlesContainer.appendChild(particle);
            }
        }

        // Create sparkles
        function createSparkles() {
            const sparkleCount = 15;
            const colors = ['#DDF344', '#ABC4FF', '#4849E8'];
            
            for (let i = 0; i < sparkleCount; i++) {
                const sparkle = document.createElement('div');
                sparkle.className = 'sparkle';
                sparkle.style.left = Math.random() * 100 + '%';
                sparkle.style.top = Math.random() * 100 + '%';
                sparkle.style.background = colors[Math.floor(Math.random() * colors.length)];
                sparkle.style.animationDelay = (Math.random() * 4) + 's';
                sparkle.style.boxShadow = `0 0 10px ${sparkle.style.background}`;
                document.body.appendChild(sparkle);
            }
        }

        // Input focus animations with glow effect
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Add hover effect to login sections
        document.querySelectorAll('.login-section').forEach(section => {
            section.addEventListener('mouseenter', function() {
                this.style.background = 'linear-gradient(180deg, rgba(72, 73, 232, 0.02) 0%, rgba(171, 196, 255, 0.08) 100%)';
            });
            
            section.addEventListener('mouseleave', function() {
                this.style.background = 'linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(171, 196, 255, 0.05) 100%)';
            });
        });

        createParticles();
        createSparkles();
    </script>
</body>
</html>