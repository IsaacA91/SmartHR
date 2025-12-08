@extends('layouts.adminHeader')

@section('title', 'Edit Employee')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<style>
    :root {
        --primary-blue: #4849E8;
        --light-blue: #ABC4FF;
        --accent-yellow: #DDF344;
        --bg-white: #F5F9FF;
    }

    body {
        background: linear-gradient(135deg, var(--bg-white) 0%, var(--light-blue) 100%);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    /* Animated Background Shapes */
    .shape {
        position: fixed;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.4;
        z-index: 0;
        animation: float 22s infinite ease-in-out;
    }

    .shape1 {
        width: 450px;
        height: 450px;
        background: var(--primary-blue);
        top: -100px;
        left: -100px;
        animation-delay: 0s;
    }

    .shape2 {
        width: 350px;
        height: 350px;
        background: var(--accent-yellow);
        bottom: -100px;
        right: -100px;
        animation-delay: 7s;
    }

    .shape3 {
        width: 400px;
        height: 400px;
        background: var(--light-blue);
        top: 50%;
        right: -150px;
        animation-delay: 14s;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate(30px, -30px) rotate(90deg); }
        50% { transform: translate(-20px, 20px) rotate(180deg); }
        75% { transform: translate(40px, 10px) rotate(270deg); }
    }

    /* Particles */
    .particle {
        position: fixed;
        width: 4px;
        height: 4px;
        background: var(--primary-blue);
        border-radius: 50%;
        opacity: 0.3;
        z-index: 0;
        animation: floatParticle 15s infinite ease-in-out;
    }

    @keyframes floatParticle {
        0%, 100% { transform: translateY(0) translateX(0); }
        50% { transform: translateY(-100px) translateX(50px); }
    }

    .edit-form-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        box-shadow: 0 20px 60px rgba(72, 73, 232, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.5);
        position: relative;
        z-index: 1;
        overflow: hidden;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .edit-form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(221, 227, 68, 0.1), transparent);
        animation: shimmer 3s infinite;
        z-index: 0;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .edit-form-container h2 {
        background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
        color: white;
        padding: 30px;
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        text-align: center;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        position: relative;
        z-index: 1;
    }

    .edit-form-container h2 i {
        font-size: 2rem;
    }

    .employee-id-label {
        text-align: center;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin: 30px 0;
        padding: 15px;
        background: rgba(171, 196, 255, 0.2);
        border-radius: 15px;
        border: 1px solid rgba(72, 73, 232, 0.1);
        position: relative;
        z-index: 1;
    }

    .employee-id-label strong {
        background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.3rem;
    }

    form {
        padding: 0 40px 40px 40px;
        position: relative;
        z-index: 1;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        animation: fieldFadeIn 0.5s ease-out backwards;
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.15s; }
    .form-group:nth-child(3) { animation-delay: 0.2s; }
    .form-group:nth-child(4) { animation-delay: 0.25s; }
    .form-group:nth-child(5) { animation-delay: 0.3s; }
    .form-group:nth-child(6) { animation-delay: 0.35s; }
    .form-group:nth-child(7) { animation-delay: 0.4s; }
    .form-group:nth-child(8) { animation-delay: 0.45s; }
    .form-group:nth-child(9) { animation-delay: 0.5s; }

    @keyframes fieldFadeIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .form-group label {
        color: var(--primary-blue);
        font-weight: 700;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-group label i {
        font-size: 1.1rem;
    }

    .form-group input,
    .form-group select {
        padding: 14px 18px;
        border-radius: 15px;
        border: 2px solid rgba(72, 73, 232, 0.2);
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(5px);
        outline: none;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 4px rgba(72, 73, 232, 0.1);
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.95);
    }

    .submit-btn {
        background: linear-gradient(135deg, var(--accent-yellow), rgba(221, 227, 68, 0.8));
        color: var(--primary-blue);
        padding: 15px 40px;
        border: none;
        border-radius: 15px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(221, 227, 68, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .submit-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .submit-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(221, 227, 68, 0.4);
    }

    .back-btn {
        background: rgba(72, 73, 232, 0.1);
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
        padding: 15px 30px;
        border-radius: 15px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(72, 73, 232, 0.3);
    }

    .form-buttons {
        display: flex;
        gap: 20px;
        margin-top: 30px;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-buttons {
            flex-direction: column;
        }

        .back-btn, .submit-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Animated Background Shapes -->
<div class="shape shape1"></div>
<div class="shape shape2"></div>
<div class="shape shape3"></div>

<!-- Particles -->
<script>
    for (let i = 0; i < 15; i++) {
        let particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 15 + 's';
        particle.style.animationDuration = (15 + Math.random() * 10) + 's';
        document.body.appendChild(particle);
    }
</script>

<div class="edit-form-container">
    <h2><i class="bi bi-pencil-square"></i> Edit Employee</h2>
    <div class="employee-id-label">
        Editing: <strong>{{ $employee->employeeID }}</strong>
    </div>

    <form action="{{ route('admin.employee.update', $employee->employeeID) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="firstName"><i class="bi bi-person"></i> First Name</label>
                <input type="text" name="firstName" value="{{ old('firstName', $employee->firstName) }}">
            </div>

            <div class="form-group">
                <label for="lastName"><i class="bi bi-person"></i> Last Name</label>
                <input type="text" name="lastName" value="{{ old('lastName', $employee->lastName) }}">
            </div>

            <div class="form-group">
                <label for="email"><i class="bi bi-envelope"></i> Email</label>
                <input type="email" name="email" value="{{ old('email', $employee->email) }}">
            </div>

            <div class="form-group">
                <label for="phone"><i class="bi bi-telephone"></i> Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}">
            </div>

            <div class="form-group">
                <label for="username"><i class="bi bi-person-badge"></i> Username</label>
                <input type="text" name="username" value="{{ old('username', $employee->username) }}">
            </div>

            <div class="form-group">
                <label for="position"><i class="bi bi-briefcase"></i> Position</label>
                <input type="text" name="position" value="{{ old('position', $employee->position) }}">
            </div>

            <div class="form-group">
                <label for="departmentID"><i class="bi bi-diagram-3"></i> Department</label>
                <select name="departmentID">
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->departmentID }}" {{ $employee->departmentID == $dept->departmentID ? 'selected' : '' }}>
                            {{ $dept->departmentName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="baseSalary"><i class="bi bi-cash"></i> Base Salary</label>
                <input type="number" step="0.01" name="baseSalary" value="{{ old('baseSalary', $employee->baseSalary) }}">
            </div>

            <div class="form-group">
                <label for="rate"><i class="bi bi-percent"></i> Hourly Rate</label>
                <input type="number" step="0.01" name="rate" value="{{ old('rate', $employee->rate) }}">
            </div>
        </div>

        <div class="form-buttons">
            <a href="{{ route('admin.employeeList') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
            <button type="submit" class="submit-btn">
                <i class="bi bi-check-circle"></i> Update Employee
            </button>
        </div>
    </form>
</div>
@endsection
