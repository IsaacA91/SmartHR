@extends('layouts.adminHeader')
@section('title','Profile')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/aprofile.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush
@section('content')
<div class="edit-admin-form">
    <form class="edit-form" method="">
        @csrf
        <h2>Edit Information</h2>
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" value="{{ $admin->firstName }}">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" value="{{ $admin->lastName }}">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $admin->email }}">
        </div>
        <button type="submit">Update Profile</button>
    </form>
</div>
@endsection