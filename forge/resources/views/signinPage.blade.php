<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartHR - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
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
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: 2rem;
        }

        .login-header {
            background: var(--primary-blue);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .login-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }

        .login-body {
            display: flex;
            flex-wrap: wrap;
        }

        .login-section {
            flex: 1;
            min-width: 300px;
            padding: 2rem;
            position: relative;
        }

        .login-section:first-child {
            border-right: 2px solid var(--bg-white);
        }

        .login-section h2 {
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(72, 73, 232, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            background: #3a3bc7;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 73, 232, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        @media (max-width: 768px) {
            .login-section:first-child {
                border-right: none;
                border-bottom: 2px solid var(--bg-white);
            }

            .login-header h1 {
                font-size: 2rem;
            }
        }

        .icon-large {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="bi bi-building"></i> SmartHR</h1>
            <p>Human Resources Management System</p>
        </div>

        <div class="login-body">
            <!-- Employee Login Section -->
            <div class="login-section">
                <h2>
                    <i class="bi bi-person-circle icon-large"></i>
                    Employee Login
                </h2>

                @if ($errors->has('username'))
                    <div class="alert alert-danger">
                        {{ $errors->first('username') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('employee.login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label for="emp-username">
                            <i class="bi bi-person"></i> Username
                        </label>
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
                        <label for="emp-password">
                            <i class="bi bi-lock"></i> Password
                        </label>
                        <input 
                            type="password" 
                            id="emp-password" 
                            name="password" 
                            required
                            placeholder="Enter your password">
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Login as Employee
                    </button>
                </form>
            </div>

            <!-- Admin Login Section -->
            <div class="login-section">
                <h2>
                    <i class="bi bi-shield-lock icon-large"></i>
                    Admin Login
                </h2>

                @if ($errors->has('adminID'))
                    <div class="alert alert-danger">
                        {{ $errors->first('adminID') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="admin-id">
                            <i class="bi bi-person-badge"></i> Admin ID
                        </label>
                        <input 
                            type="text" 
                            id="admin-id" 
                            name="adminID" 
                            value="{{ old('adminID') }}"
                            required
                            placeholder="Enter your admin ID">
                    </div>

                    <div class="form-group">
                        <label for="admin-password">
                            <i class="bi bi-lock-fill"></i> Password
                        </label>
                        <input 
                            type="password" 
                            id="admin-password" 
                            name="password" 
                            required
                            placeholder="Enter your password">
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-shield-check"></i>
                        Login as Admin
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>