@extends('layouts.app')
@section('title', 'Dashboard')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/edashboard.css') }}">
<link 
  rel="stylesheet" 
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush
@section('content')

<div class="container dash">
    <h1 class="greeting">Welcome back, {{$employee->firstName}}!</h1>
    <a href="{{ route('employeeProfile',['id' => $employee->employeeID])}}" class="profile-link">
        <i class="bi bi-person-circle"></i>
        <p class="view">View Profile</p>
    </a>

    <div class="grid">
        <a href="#" class="card" title="Request Time Off">
            <i class="bi bi-clock-fill" aria-hidden="true"></i>
            <span>Request Time Off</span>
        </a>

        <a href="#" class="card" title="View Attendance">
            <i class="bi bi-calendar" aria-hidden="true"></i>
            <span>View Attendance</span>
        </a>

        <a href="#" class="card" title="View Payroll">
            <i class="bi bi-cash-coin" aria-hidden="true"></i>
            <span>View Payroll</span>
        </a>
    </div>
</div>

@endsection


<!--
        Bootstrap Icons 
<i class="bi bi-clock-fill"></i> -- Request Time Off
<i class="bi bi-calendar"></i> -- View Attendance
<i class="bi bi-cash-coin"></i> -- View Payroll
<i class="bi bi-person-circle"></i> -- View Profile
-->