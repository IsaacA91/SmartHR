@extends('layouts.adminHeader')
@section('title','Profile')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/aprofile.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <div class="avatar">
            <div class="img_container">
                @if($admin->profilePhoto)
                    <img src="{{ asset('storage/' . $admin->profilePhoto) }}" class="profile-img">
                @else
                    <div class="profile-placeholder">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
            </div>
        </div>
            
        <div class="headings">
            <p class="admin-name">{{$admin->firstName}} {{$admin->lastName}}</p>
            <p class="admin-role">ADMINISTRATOR</p>
        </div>

        <div class="info-section">
            <ul class="info-list">
                <li>
                    <i class="bi bi-person-badge"></i>
                    <p class="info-text">{{$admin->adminID}}</p>
                </li>
                <li>
                    <i class="bi bi-building"></i>
                    <p class="info-text">{{$admin->companyID}}</p>
                </li>
            </ul>
        </div>

        <form action="{{ route('admin.uploadProfilePhoto') }}" method="POST" enctype="multipart/form-data" class="photo-form">
            @csrf
            <input type="file" name="photo" id="photoInput" accept="image/*" style="display: none;" onchange="previewAndSubmit(this)">
            <button type="button" onclick="document.getElementById('photoInput').click()" class="change-photo-btn">
                <i class="bi bi-camera-fill"></i> Change Photo
            </button>
        </form>
    </div>
</div>
@endsection

