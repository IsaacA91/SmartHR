<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile - SmartHR</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            color: #333;
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
            filter: blur(70px);
            opacity: 0.3;
            animation: float 22s infinite ease-in-out;
        }

        .shape1 {
            width: 450px;
            height: 450px;
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
            animation-delay: 8s;
        }

        .shape3 {
            width: 350px;
            height: 350px;
            background: var(--accent-yellow);
            top: 40%;
            right: 10%;
            animation-delay: 16s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(40px, -40px) rotate(90deg); }
            50% { transform: translate(-30px, 30px) rotate(180deg); }
            75% { transform: translate(50px, 15px) rotate(270deg); }
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(72, 73, 232, 0.1);
            padding: 1rem 0;
            position: relative;
            z-index: 100;
        }

        .navbar-brand {
            color: var(--primary-blue) !important;
            font-weight: 800;
            font-size: 1.8rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .nav-link {
            color: var(--primary-blue) !important;
            font-weight: 600;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(72, 73, 232, 0.1);
            transform: translateY(-2px);
        }

        .profile-container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 32px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(72, 73, 232, 0.15);
            display: flex;
            gap: 3rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
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

        .profile-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(221, 243, 68, 0.05), transparent);
            animation: shimmer 4s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .left-profile {
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .profile-picture {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--light-blue), rgba(171, 196, 255, 0.5));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            color: var(--primary-blue);
            border: 6px solid white;
            box-shadow: 0 10px 30px rgba(72, 73, 232, 0.2);
            animation: pulse 3s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 10px 30px rgba(72, 73, 232, 0.2); }
            50% { transform: scale(1.05); box-shadow: 0 15px 40px rgba(72, 73, 232, 0.3); }
        }

        .right-profile {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .right-profile h1 {
            color: var(--primary-blue);
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .right-profile h3 {
            color: #475569;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .right-profile h2 {
            color: #64748b;
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .right-profile hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, var(--light-blue), transparent);
            margin: 2rem 0;
        }

        .info-badge {
            display: inline-block;
            background: rgba(72, 73, 232, 0.1);
            color: var(--primary-blue);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .action-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            box-shadow: 0 10px 40px rgba(72, 73, 232, 0.15);
            display: flex;
            justify-content: space-around;
            gap: 1rem;
            margin-bottom: 2rem;
            animation: fadeIn 1s ease-out 0.4s both;
            position: relative;
            overflow: hidden;
        }

        .action-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(221, 243, 68, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .action-btn {
            flex: 1;
            position: relative;
            text-decoration: none;
            background: linear-gradient(135deg, var(--primary-blue), #6366f1);
            color: white;
            padding: 1.25rem 2rem;
            border-radius: 15px;
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(72, 73, 232, 0.3);
            border: none;
            cursor: pointer;
        }

        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(72, 73, 232, 0.4);
            color: white;
        }

        .action-btn:active {
            transform: translateY(-2px);
        }

        .action-btn i {
            font-size: 1.5rem;
        }

        .buttons {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeIn 1s ease-out 0.4s both;
        }

        .pushable {
            position: relative;
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
            outline-offset: 4px;
            transition: filter 250ms;
        }

        .shadow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 16px;
            background: rgba(72, 73, 232, 0.3);
            will-change: transform;
            transform: translateY(3px);
            transition: transform 600ms cubic-bezier(.3, .7, .4, 1);
        }

        .edge {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 16px;
            background: linear-gradient(
                to left,
                #3637b8 0%,
                var(--primary-blue) 8%,
                var(--primary-blue) 92%,
                #3637b8 100%
            );
        }

        .front {
            display: block;
            position: relative;
            padding: 20px 45px;
            border-radius: 16px;
            font-size: 1.15rem;
            color: white;
            background: linear-gradient(135deg, var(--primary-blue) 0%, #6366f1 100%);
            will-change: transform;
            transform: translateY(-5px);
            transition: transform 600ms cubic-bezier(.3, .7, .4, 1);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .pushable:hover {
            filter: brightness(110%);
        }

        .pushable:hover .front {
            transform: translateY(-8px);
            transition: transform 250ms cubic-bezier(.3, .7, .4, 1.5);
        }

        .pushable:active .front {
            transform: translateY(-2px);
            transition: transform 34ms;
        }

        .pushable:hover .shadow {
            transform: translateY(6px);
            transition: transform 250ms cubic-bezier(.3, .7, .4, 1.5);
        }

        .pushable:active .shadow {
            transform: translateY(1px);
            transition: transform 34ms;
        }

        .btn-link {
            background: none;
            border: none;
            padding: 0;
        }

        @media (max-width: 768px) {
            .profile-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 2rem;
            }

            .right-profile h1 {
                font-size: 2.25rem;
            }

            .right-profile h2,
            .right-profile h3 {
                justify-content: center;
            }

            .profile-picture {
                width: 150px;
                height: 150px;
                font-size: 4rem;
            }

            .action-bar {
                flex-direction: column;
                gap: 1rem;
            }

            .action-btn {
                width: 100%;
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

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 0 2rem;">
            <a class="navbar-brand" href="{{ route('employee.dashboard') }}">
                <i class="bi bi-building"></i> SmartHR
            </a>
        </div>
    </nav>

    <div class="profile-container">
        <div class="action-bar">
            <a href="{{ route('employee.dashboard') }}" class="action-btn">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('attendance.dashboard') }}" class="action-btn">
                <i class="bi bi-calendar-check-fill"></i> Attendance
            </a>
            <a href="{{ route('leave.index') }}" class="action-btn">
                <i class="bi bi-calendar-x-fill"></i> Vacation
            </a>
            <a href="{{ route('employee.payroll.index') }}" class="action-btn">
                <i class="bi bi-cash-coin"></i> Payroll
            </a>
            <form method="POST" action="{{ route('employee.logout') }}" style="flex: 1; margin: 0;">
                @csrf
                <button type="submit" class="action-btn" style="width: 100%;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        @if(session('success'))
            <div style="background: #22c55e; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; font-weight: 600; position: relative; z-index: 10;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #ef4444; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; position: relative; z-index: 10;">
                @foreach($errors->all() as $error)
                    <div><i class="bi bi-exclamation-circle-fill"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="profile-card">
            <div class="left-profile">
                <div class="profile-picture">
                    @if($employee->profilePhoto)
                        <img src="{{ asset('storage/' . $employee->profilePhoto) }}" alt="Profile Photo" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    @else
                        <i class="bi bi-person-fill"></i>
                    @endif
                </div>
                <form action="{{ route('employee.profile.photo.upload') }}" method="POST" enctype="multipart/form-data" style="margin-top: 1rem; text-align: center;">
                    @csrf
                    <input type="file" name="photo" id="photoInput" accept="image/*" style="display: none;" onchange="previewAndSubmit(this)">
                    <button type="button" onclick="document.getElementById('photoInput').click()" class="btn" style="background: var(--primary-blue); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer; font-weight: 600; margin-bottom: 0.5rem; width: 100%;">
                        <i class="bi bi-camera-fill"></i> Change Photo
                    </button>
                </form>
                @if($employee->profilePhoto)
                    <form action="{{ route('employee.profile.photo.delete') }}" method="POST" style="text-align: center;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: #ef4444; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%;" onclick="return confirm('Are you sure you want to delete your profile photo?')">
                            <i class="bi bi-trash-fill"></i> Remove Photo
                        </button>
                    </form>
                @endif
            </div>
            <div class="right-profile">
                <h1>{{ $employee->firstName }} {{ $employee->lastName }}</h1>
                <div class="info-badge">
                    <i class="bi bi-building"></i> Company ID: {{ $employee->companyID }}
                </div>
                <h2><i class="bi bi-briefcase-fill"></i> {{ $employee->position }}</h2>
                <h2><i class="bi bi-diagram-3-fill"></i> {{ $employee->department->departmentName ?? $employee->departmentID }}</h2>
                
                <hr>
                
                <h3><i class="bi bi-envelope-fill"></i> Contact Information</h3>
                <h2><i class="bi bi-envelope"></i> {{ $employee->email }}</h2>
                <h2><i class="bi bi-telephone-fill"></i> {{ $employee->phone }}</h2>
                
                <hr>
                
                <h3><i class="bi bi-cash-stack"></i> Employment Details</h3>
                <h2><i class="bi bi-currency-dollar"></i> Base Salary: ${{ number_format($employee->baseSalary, 2) }}</h2>
                <h2><i class="bi bi-clock-fill"></i> Hourly Rate: ${{ number_format($employee->rate, 2) }}</h2>
            </div>
        </div>
    </div>

    <script>
        // Navbar collapse for Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            if (navbarToggler) {
                navbarToggler.addEventListener('click', function() {
                    navbarCollapse.classList.toggle('show');
                });
            }
        });

        function previewAndSubmit(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileSize = file.size / 1024 / 1024; // Convert to MB
                
                // Validate file size (2MB max)
                if (fileSize > 2) {
                    alert('File size must be less than 2MB');
                    input.value = '';
                    return;
                }
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please upload a valid image file (JPEG, PNG, JPG, or GIF)');
                    input.value = '';
                    return;
                }
                
                // Submit form automatically after validation
                input.form.submit();
            }
        }
    </script>
</body>
</html>