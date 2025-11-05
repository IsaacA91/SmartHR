<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartHR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #4849E8;
            --light-blue: #ABC4FF;
            --accent-yellow: #DDF344;
            --bg-white: #F5F9FF;
        }
        
        body {
            background: var(--primary-blue);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: var(--bg-white);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-primary:hover {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--primary-blue);
        }

        .form-control:focus {
            border-color: var(--light-blue);
            box-shadow: 0 0 0 0.25rem rgba(72, 73, 232, 0.25);
        }

        .alert-danger {
            background-color: var(--light-blue);
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .text-muted {
            color: var(--light-blue) !important;
        }

        hr {
            border-color: var(--light-blue);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h3 class="text-center mb-4">SmartHR Login</h3>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('username') }}
            </div>
        @endif

        <form method="POST" action="{{ route('employee.login') }}">
            @csrf 
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <hr>
        <p class="text-center text-muted">Test Account: asmith / pass123</p>
    </div>
</body>
</html>