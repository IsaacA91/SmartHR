<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartHR</title>
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
            padding: 2rem;
            background-image: radial-gradient(circle at 50% 50%, rgba(171, 196, 255, 0.1) 0%, rgba(72, 73, 232, 0.2) 100%);
        }
        
        .login-card {
            background: var(--bg-white);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            position: relative;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--neon-yellow);
            border-radius: 24px 24px 0 0;
        }

        h3 {
            color: var(--primary-blue);
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 2rem;
            text-align: center;
            letter-spacing: -0.5px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.75rem;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--light-blue);
            border-radius: 12px;
            font-size: 1.1rem;
            background: white;
            transition: all 0.2s;
            color: var(--primary-blue);
            margin-bottom: 1rem;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(72, 73, 232, 0.1);
        }

        button {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary-blue);
            color: var(--neon-yellow);
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
        }

        button:hover {
            background-color: var(--neon-yellow);
            color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 73, 232, 0.2);
        }

        .error-message {
            background-color: #FF4D4D15;
            color: #FF4D4D;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message::before {
            content: '!';
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background: #FF4D4D;
            color: white;
            border-radius: 50%;
            font-weight: bold;
        }

        hr {
            margin: 2rem 0;
            border: none;
            border-top: 2px solid var(--light-blue);
            opacity: 0.2;
        }

        .test-account {
            text-align: center;
            color: var(--primary-blue);
            opacity: 0.7;
            font-size: 0.9rem;
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
        <h3>Employee Login</h3>
        
        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first('username') }}
            </div>
        @endif

        <form method="POST" action="{{ route('employee.login') }}">
            @csrf 
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <hr>
        <p class="test-account">Test Account: asmith / pass123</p>
        <a href='/admin/login'>Admin Login</a>
    </div>
</body>
</html>