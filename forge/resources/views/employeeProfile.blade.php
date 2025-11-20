<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile - SmartHR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-blue: #4849E8;
            --light-blue: #ABC4FF;
            --accent-yellow: #DDF344;
            --bg-white: #F5F9FF;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            min-height: 100vh;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: white !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: var(--primary-blue) !important;
            font-weight: bold;
            font-size: 1.8rem;
        }

        .nav-link {
            color: var(--primary-blue) !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--light-blue) !important;
        }

        .profile-container {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 2rem;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            display: flex;
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .left-profile {
            flex-shrink: 0;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: var(--light-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--primary-blue);
            border: 5px solid var(--primary-blue);
        }

        .right-profile {
            flex: 1;
        }

        .right-profile h1 {
            color: var(--primary-blue);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .right-profile h3 {
            color: #666;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .right-profile h2 {
            color: #555;
            font-size: 1rem;
            font-weight: 400;
            margin-bottom: 0.5rem;
        }

        .right-profile hr {
            border-top: 2px solid var(--light-blue);
            margin: 1.5rem 0;
        }

        .buttons {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            justify-content: center;
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
            border-radius: 12px;
            background: hsl(0deg 0% 0% / 0.25);
            will-change: transform;
            transform: translateY(2px);
            transition: transform 600ms cubic-bezier(.3, .7, .4, 1);
        }

        .edge {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 12px;
            background: linear-gradient(
                to left,
                hsl(240deg 80% 40%) 0%,
                hsl(240deg 80% 50%) 8%,
                hsl(240deg 80% 50%) 92%,
                hsl(240deg 80% 40%) 100%
            );
        }

        .front {
            display: block;
            position: relative;
            padding: 18px 40px;
            border-radius: 12px;
            font-size: 1.1rem;
            color: white;
            background: var(--primary-blue);
            will-change: transform;
            transform: translateY(-4px);
            transition: transform 600ms cubic-bezier(.3, .7, .4, 1);
            font-weight: 600;
        }

        .pushable:hover {
            filter: brightness(110%);
        }

        .pushable:hover .front {
            transform: translateY(-6px);
            transition: transform 250ms cubic-bezier(.3, .7, .4, 1.5);
        }

        .pushable:active .front {
            transform: translateY(-2px);
            transition: transform 34ms;
        }

        .pushable:hover .shadow {
            transform: translateY(4px);
            transition: transform 250ms cubic-bezier(.3, .7, .4, 1.5);
        }

        .pushable:active .shadow {
            transform: translateY(1px);
            transition: transform 34ms;
        }

        @media (max-width: 768px) {
            .profile-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .right-profile h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('employee.dashboard') }}">
                <i class="bi bi-building"></i> SmartHR
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employee.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('attendance.dashboard') }}">
                            <i class="bi bi-clock-history"></i> Attendance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('leave.index') }}">
                            <i class="bi bi-calendar-x"></i> Leave Requests
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employee.payroll.index') }}">
                            <i class="bi bi-cash-coin"></i> Payroll
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('employee.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="profile-container">
        <div class="profile-card">
            <div class="left-profile">
                <div class="profile-picture">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
            <div class="right-profile">
                <h1>{{ $employee->firstName }} {{ $employee->lastName }}</h1>
                <h3>Company ID: {{ $employee->companyID }}</h3>
                <h2>{{ $employee->position }}</h2>
                <h2>Department: {{ $employee->departmentID }}</h2>
                <hr>
                <h3>Contact Information</h3>
                <h2><i class="bi bi-envelope"></i> {{ $employee->email }}</h2>
                <h2><i class="bi bi-telephone"></i> {{ $employee->phone }}</h2>
                <hr>
                <h3>Employment Details</h3>
                <h2><i class="bi bi-cash"></i> Base Salary: ₱{{ number_format($employee->baseSalary, 2) }}</h2>
                <h2><i class="bi bi-clock"></i> Hourly Rate: ₱{{ number_format($employee->rate, 2) }}</h2>
            </div>
        </div>

        <div class="buttons">
            <a href="{{ route('attendance.dashboard') }}" class="pushable">
                <span class="shadow"></span>
                <span class="edge"></span>
                <span class="front">
                    <i class="bi bi-calendar-check"></i> Attendance
                </span>
            </a>
            <a href="{{ route('leave.index') }}" class="pushable">
                <span class="shadow"></span>
                <span class="edge"></span>
                <span class="front">
                    <i class="bi bi-calendar-x"></i> Vacation
                </span>
            </a>
            <a href="{{ route('employee.payroll.index') }}" class="pushable">
                <span class="shadow"></span>
                <span class="edge"></span>
                <span class="front">
                    <i class="bi bi-cash-coin"></i> Payroll
                </span>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>