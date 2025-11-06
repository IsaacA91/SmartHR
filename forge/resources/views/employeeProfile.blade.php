@extends('layouts.app')
@section('title', 'Employee Profile')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/eprofile.css') }}">
@endpush
@section('content')
  <div class="profile-container">
    <div class="profile-card">
      <div class="left-profile">
        <div class="profile-picture"></div>
      </div>
      <div class="right-profile">
        <h1>{{$employee->firstName}} {{$employee->lastName}}</h1>
        <h3>Company | {{$employee->company}}</h3>
        <h2>Department Position | {{$employee->department}} {{$employee->position}}</h2>
        <hr>
        <h3>Contact Information</h3>
        <h2>Email | {{$employee->email}}</h2>
        <h2>Phone | {{$employee->phone}}</h2>
      </div>
    </div>
    <div class="buttons">
      <button class="pushable">
        <span class="shadow"></span>
        <span class="edge"></span>
        <span class="front"> Attendence </span>
      </button>
      <button class="pushable">
        <span class="shadow"></span>
        <span class="edge"></span>
        <span class="front"> Vacation </span>
      </button>
      <button class="pushable">
        <span class="shadow"></span>
        <span class="edge"></span>
        <span class="front"> Payroll </span>
      </button>
    </div>
  </div>
@endsection
