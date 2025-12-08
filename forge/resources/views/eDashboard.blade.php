@extends('layouts.app')
@section('title', 'Dashboard')
@push('styles')
<style>
:root {
    --blue-white: #F5F9FF;
    --sky-blue: #ABC4FF;
    --blurple: #4849E8;
    --highlighter: #DDF344;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #F5F9FF;
    min-height: 100vh;
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
    filter: blur(60px);
    opacity: 0.3;
    animation: float 20s infinite ease-in-out;
}

.shape1 {
    width: 400px;
    height: 400px;
    background: #ABC4FF;
    top: -100px;
    left: -100px;
    animation-delay: 0s;
}

.shape2 {
    width: 350px;
    height: 350px;
    background: #4849E8;
    top: 50%;
    right: -100px;
    animation-delay: 5s;
}

.shape3 {
    width: 300px;
    height: 300px;
    background: #DDF344;
    bottom: -100px;
    left: 30%;
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    25% { transform: translate(30px, -30px) rotate(90deg); }
    50% { transform: translate(-20px, 20px) rotate(180deg); }
    75% { transform: translate(40px, 10px) rotate(270deg); }
}

.container.dash {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 20px;
    position: relative;
    z-index: 1;
}

/* Header section with wave effect */
.header-section {
    text-align: center;
    margin-bottom: 4rem;
    position: relative;
}

.greeting {
    font-size: 3.5rem;
    color: #4849E8;
    font-weight: 800;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #4849E8 0%, #ABC4FF 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: slideDown 0.8s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.subtitle {
    color: #64748b;
    font-size: 1.2rem;
    animation: fadeIn 1s ease-out 0.3s both;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Glassmorphism profile card */
.profile-section {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 24px;
    padding: 2.5rem;
    margin-bottom: 3rem;
    box-shadow: 0 8px 32px rgba(72, 73, 232, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    position: relative;
    overflow: hidden;
    animation: scaleIn 0.6s ease-out 0.4s both;
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.profile-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(221, 243, 68, 0.1), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

.profile-info {
    flex: 1;
    position: relative;
    z-index: 1;
}

.profile-info h3 {
    color: #4849E8;
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.profile-info p {
    color: #64748b;
    font-size: 1.05rem;
}

.profile-link {
    background: linear-gradient(135deg, #4849E8 0%, #6366f1 100%);
    color: white;
    border-radius: 16px;
    padding: 14px 28px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 16px rgba(72, 73, 232, 0.3);
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.profile-link::before {
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

.profile-link:hover::before {
    width: 300px;
    height: 300px;
}

.profile-link:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(72, 73, 232, 0.4);
}

.profile-link i {
    font-size: 1.3rem;
    position: relative;
    z-index: 1;
}

.profile-link span {
    position: relative;
    z-index: 1;
}

/* Unique card grid with staggered animation */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    padding: 2.5rem;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1.2rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 24px rgba(72, 73, 232, 0.08);
    border: 2px solid transparent;
    min-height: 220px;
    position: relative;
    overflow: hidden;
    animation: cardSlideIn 0.6s ease-out both;
}

.card:nth-child(1) { animation-delay: 0.5s; }
.card:nth-child(2) { animation-delay: 0.65s; }
.card:nth-child(3) { animation-delay: 0.8s; }
.card:nth-child(4) { animation-delay: 0.95s; }

@keyframes cardSlideIn {
    from {
        opacity: 0;
        transform: translateY(40px) rotateX(-10deg);
    }
    to {
        opacity: 1;
        transform: translateY(0) rotateX(0);
    }
}

.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    transition: height 0.4s ease;
}

.card.time-off::before {
    background: linear-gradient(90deg, #DDF344, #f4e95d);
}

.card.attendance::before {
    background: linear-gradient(90deg, #ABC4FF, #8fa9ff);
}

.card.payroll::before {
    background: linear-gradient(90deg, #4849E8, #6366f1);
}

.card.leave-history::before {
    background: linear-gradient(90deg, #ABC4FF, #4849E8);
}

.card:hover::before {
    height: 100%;
    opacity: 0.1;
}

.card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 20px 40px rgba(72, 73, 232, 0.2);
    border-color: rgba(72, 73, 232, 0.3);
}

.card-icon-wrapper {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: all 0.4s ease;
}

.card.time-off .card-icon-wrapper {
    background: linear-gradient(135deg, rgba(221, 243, 68, 0.2), rgba(221, 243, 68, 0.05));
}

.card.attendance .card-icon-wrapper {
    background: linear-gradient(135deg, rgba(171, 196, 255, 0.2), rgba(171, 196, 255, 0.05));
}

.card.payroll .card-icon-wrapper {
    background: linear-gradient(135deg, rgba(72, 73, 232, 0.2), rgba(72, 73, 232, 0.05));
}

.card.leave-history .card-icon-wrapper {
    background: linear-gradient(135deg, rgba(171, 196, 255, 0.2), rgba(72, 73, 232, 0.05));
}

.card:hover .card-icon-wrapper {
    transform: rotateY(360deg);
}

.card i {
    font-size: 2.5rem;
    color: #4849E8;
}

.card span {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1e293b;
    text-align: center;
}

.card p {
    color: #64748b;
    font-size: 0.95rem;
    text-align: center;
    margin: 0;
}

/* Floating particles */
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
    width: 4px;
    height: 4px;
    background: #4849E8;
    border-radius: 50%;
    opacity: 0.3;
}

@media (max-width: 768px) {
    .greeting {
        font-size: 2.5rem;
    }
    
    .profile-section {
        flex-direction: column;
        text-align: center;
    }
    
    .grid {
        grid-template-columns: 1fr;
    }
    
    .card {
        min-height: 200px;
    }
}

/* Scroll reveal effect */
.reveal {
    opacity: 0;
    transform: translateY(30px);
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
    transition: all 0.8s ease;
}
</style>
<link 
  rel="stylesheet" 
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush
@section('content')

<!-- Animated background shapes -->
<div class="bg-shapes">
    <div class="shape shape1"></div>
    <div class="shape shape2"></div>
    <div class="shape shape3"></div>
</div>

<!-- Floating particles -->
<div class="particles" id="particles"></div>

<div class="container dash">
    <div class="header-section">
        <h1 class="greeting">Welcome back, {{$employee->firstName}}!</h1>
        <p class="subtitle"> Manage your work life in one beautiful place</p>
    </div>

    <div class="profile-section reveal">
        <div style="display: flex; align-items: center; gap: 1.5rem; width: 100%;">
            <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 3px solid var(--primary-blue); box-shadow: 0 4px 15px rgba(72, 73, 232, 0.2); flex-shrink: 0;">
                @if($employee->profilePhoto)
                    <img src="{{ asset('storage/' . $employee->profilePhoto) }}" alt="Profile Photo" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--light-blue), var(--primary-blue)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
            </div>
            <div class="profile-info" style="flex: 1;">
                <h3>{{ $employee->firstName }} {{ $employee->lastName }}</h3>
                <p>{{ $employee->position ?? 'Employee' }} • {{ $employee->department->departmentName ?? 'N/A' }}</p>
            </div>
        </div>
        <a href="{{ route('employee.profile', ['id' => $employee->employeeID]) }}" class="profile-link">
            <i class="bi bi-person-circle"></i>
            <span>View Profile</span>
        </a>
    </div>

    <div class="grid">
        <a href="{{ route('leave.create') }}" class="card time-off reveal" title="Request Time Off">
            <div class="card-icon-wrapper">
                <i class="bi bi-clock-fill" aria-hidden="true"></i>
            </div>
            <span>Request Time Off</span>
            <p>Submit a new leave request</p>
        </a>

        <a href="{{ route('attendance.dashboard') }}" class="card attendance reveal" title="View Attendance">
            <div class="card-icon-wrapper">
                <i class="bi bi-calendar-check" aria-hidden="true"></i>
            </div>
            <span>View Attendance</span>
            <p>Clock in/out and track attendance</p>
        </a>

        <a href="{{ route('employee.payroll.index') }}" class="card payroll reveal" title="View Payroll">
            <div class="card-icon-wrapper">
                <i class="bi bi-cash-coin" aria-hidden="true"></i>
            </div>
            <span>View Payroll</span>
            <p>Access your payslips & earnings</p>
        </a>

        <a href="{{ route('employee.leave.directory') }}" class="card leave-history reveal" title="View Leave Requests">
            <div class="card-icon-wrapper">
                <i class="bi bi-calendar-x" aria-hidden="true"></i>
            </div>
            <span>My Leave Requests</span>
            <p>View all your leave history</p>
        </a>
    </div>
</div>

<script>
// Generate floating particles
function createParticles() {
    const particlesContainer = document.getElementById('particles');
    const particleCount = 15;
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animationDuration = (Math.random() * 20 + 10) + 's';
        particle.style.animationDelay = Math.random() * 5 + 's';
        particle.style.animation = `float ${Math.random() * 20 + 10}s infinite ease-in-out`;
        particlesContainer.appendChild(particle);
    }
}

// Scroll reveal animation
function reveal() {
    const reveals = document.querySelectorAll('.reveal');
    reveals.forEach(element => {
        const windowHeight = window.innerHeight;
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < windowHeight - elementVisible) {
            element.classList.add('active');
        }
    });
}

// 3D tilt effect on cards
function addTiltEffect() {
    const cards = document.querySelectorAll('.card');
    
    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;
            
            card.style.transform = `translateY(-12px) scale(1.02) perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1) perspective(1000px) rotateX(0) rotateY(0)';
        });
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    createParticles();
    reveal();
    addTiltEffect();
});

window.addEventListener('scroll', reveal);
</script>

@endsection
