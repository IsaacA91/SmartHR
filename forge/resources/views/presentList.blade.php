@extends('layouts.adminHeader')

@section('title', 'Employee Directory')

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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

    .employee-table-container {
        max-width: 1200px;
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

    .employee-table-container::before {
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

    .employee-table-container h2 {
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

    .employee-table-container h2 i {
        font-size: 2rem;
    }

    .table-wrapper {
        padding: 40px;
        position: relative;
        z-index: 1;
    }

    table.employee-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 1rem;
        border-radius: 15px;
        overflow: hidden;
    }

    table.employee-table thead {
        background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
        color: white;
    }

    table.employee-table th {
        padding: 18px;
        text-align: left;
        font-weight: 700;
        border: none;
    }

    table.employee-table th i {
        margin-right: 8px;
    }

    table.employee-table tbody tr {
        transition: all 0.3s ease;
        animation: rowFadeIn 0.5s ease-out backwards;
    }

    table.employee-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
    table.employee-table tbody tr:nth-child(2) { animation-delay: 0.15s; }
    table.employee-table tbody tr:nth-child(3) { animation-delay: 0.2s; }
    table.employee-table tbody tr:nth-child(4) { animation-delay: 0.25s; }
    table.employee-table tbody tr:nth-child(5) { animation-delay: 0.3s; }
    table.employee-table tbody tr:nth-child(6) { animation-delay: 0.35s; }
    table.employee-table tbody tr:nth-child(7) { animation-delay: 0.4s; }
    table.employee-table tbody tr:nth-child(8) { animation-delay: 0.45s; }
    table.employee-table tbody tr:nth-child(9) { animation-delay: 0.5s; }
    table.employee-table tbody tr:nth-child(10) { animation-delay: 0.55s; }

    @keyframes rowFadeIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    table.employee-table tbody tr:nth-child(even) {
        background-color: rgba(171, 196, 255, 0.1);
    }

    table.employee-table tbody tr:hover {
        background: rgba(171, 196, 255, 0.3);
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(72, 73, 232, 0.1);
    }

    table.employee-table td {
        padding: 18px;
        border-bottom: 1px solid rgba(72, 73, 232, 0.1);
        color: var(--primary-blue);
        font-weight: 600;
    }

    .search-container {
        margin-bottom: 1.5rem;
        display: flex;
        gap: 10px;
        align-items: center;
        position: relative;
        z-index: 1;
    }
    
    .search-container input {
        flex: 1;
        padding: 12px 18px;
        border: 2px solid rgba(72, 73, 232, 0.2);
        border-radius: 12px;
        font-size: 1rem;
        color: var(--primary-blue);
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        font-weight: 600;
    }
    
    .search-container input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(72, 73, 232, 0.1);
    }
    
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid var(--light-blue);
        border-top: none;
        border-radius: 0 0 12px 12px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: none;
    }
    
    .search-suggestions.active {
        display: block;
    }
    
    .suggestion-item {
        padding: 12px 18px;
        cursor: pointer;
        border-bottom: 1px solid #f0f4ff;
        transition: background-color 0.2s;
    }
    
    .suggestion-item:hover {
        background-color: #e6f0ff;
    }
    
    .suggestion-item:last-child {
        border-bottom: none;
    }
    
    .suggestion-highlight {
        font-weight: 700;
        color: var(--primary-blue);
    }
    
    .suggestion-details {
        font-size: 0.85rem;
        color: #666;
        margin-top: 2px;
    }

    .no-data {
        text-align: center;
        padding: 60px 20px;
        font-style: italic;
        color: var(--light-blue);
        font-size: 1.2rem;
        font-weight: 600;
    }

    .pagination-wrapper {
        text-align: center;
        margin-top: 30px;
        padding: 0 40px 40px 40px;
        position: relative;
        z-index: 1;
    }

    .pagination-wrapper .pagination {
        display: inline-flex;
        gap: 10px;
        margin: 0;
    }

    .pagination-wrapper .pagination li {
        display: inline;
    }

    .pagination-wrapper .pagination li a,
    .pagination-wrapper .pagination li span {
        padding: 12px 18px;
        border: 2px solid rgba(72, 73, 232, 0.2);
        border-radius: 12px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
        display: inline-block;
    }

    .pagination-wrapper .pagination li a:hover {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(72, 73, 232, 0.3);
    }

    .pagination-wrapper .pagination li.active span {
        background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
        color: white;
        border-color: var(--primary-blue);
        box-shadow: 0 5px 15px rgba(72, 73, 232, 0.3);
    }

    .pagination-wrapper .pagination li.disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    button {
        padding: 12px 18px;
        border: 2px solid rgba(72, 73, 232, 0.2);
        border-radius: 12px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    button:hover {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(72, 73, 232, 0.3);
    }

    @media (max-width: 768px) {
        table.employee-table {
            display: block;
            overflow-x: auto;
        }

        .table-wrapper {
            padding: 20px;
        }

        .pagination-wrapper {
            padding: 0 20px 20px 20px;
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

<div class="employee-table-container">
    <h2><i class="bi bi-people-fill"></i> Employees Present Today</h2>

    <div class="search-container">
        <form method="GET" action="{{ route('admin.presentList') }}" style="display: flex; gap: 10px; width: 100%; position: relative;">
            <div style="flex: 1; position: relative;">
                <input 
                    type="text" 
                    id="searchInput"
                    name="search" 
                    placeholder="Search by name, employee ID, department, or position..." 
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
                <div id="searchSuggestions" class="search-suggestions"></div>
            </div>
            <button type="submit"><i class="bi bi-search"></i> Search</button>
            @if(request('search'))
                <a href="{{ route('admin.presentList') }}"><button type="button"><i class="bi bi-x-circle"></i> Clear</button></a>
            @endif
        </form>
    </div>

    @if ($presentToday->count())
        <div class="table-wrapper">
            <table class="employee-table">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash"></i> #</th>
                        <th><i class="bi bi-person-badge"></i> Employee ID</th>
                        <th><i class="bi bi-person"></i> Full Name</th>
                        <th><i class="bi bi-building"></i> Department</th>
                        <th><i class="bi bi-briefcase"></i> Position</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($presentToday as $index => $employee)
                        <tr>
                            <td>{{ $presentToday->firstItem() + $index }}</td>
                            <td>{{ $employee->employeeID }}</td>
                            <td>{{ $employee->firstName }} {{ $employee->lastName }}</td>
                            <td>{{ $employee->departmentName ?? '—' }}</td>
                            <td>{{ $employee->position ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            {{ $presentToday->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="table-wrapper">
            <div class="no-data"><i class="bi bi-inbox"></i> No employees found.</div>
        </div>
    @endif
</div>
@endsection