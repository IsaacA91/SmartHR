<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SmartHR</title>
    <style>
        :root {
            --primary-blue: #4849E8;
            --light-blue: #ABC4FF;
            --neon-yellow: #DDF344;
            --white: #F5F9FF;
            --card-shadow: 0 8px 24px rgba(72, 73, 232, 0.15);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--primary-blue);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: radial-gradient(circle at 50% 50%, rgba(171, 196, 255, 0.1) 0%, rgba(72, 73, 232, 0.2) 100%);
        }

        .login-container {
            background-color: var(--white);
            padding: 3rem;
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            width: 100%;
            max-width: 400px;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--neon-yellow);
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .header h1 {
            color: var(--primary-blue);
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }

        .header p {
            color: var(--primary-blue);
            opacity: 0.8;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--light-blue);
            border-radius: 12px;
            font-size: 1.1rem;
            background: white;
            transition: all 0.2s;
            color: var(--primary-blue);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(72, 73, 232, 0.1);
        }

        .submit-button {
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
        }

        .submit-button:hover {
            background-color: var(--neon-yellow);
            color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 73, 232, 0.2);
        }

        .error {
            color: #FF4D4D;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error::before {
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="header">
            <h1>Admin Login</h1>
            <p>Please sign in to continue</p>
        </div>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="form-group">
                <label for="adminID">Admin ID</label>
                <input type="text" id="adminID" name="adminID" value="{{ old('adminID') }}" required autofocus maxlength="4" placeholder="AXXX">
                @error('adminID')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required maxlength="12">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-button">Login</button>
        </form>
    </div>
</body>
</html>