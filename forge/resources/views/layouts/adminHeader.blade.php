<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Actor&family=Momo+Trust+Display&family=Patrick+Hand&family=Poltawski+Nowy:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @stack('styles')
    <title>@yield('title', 'SmartHR')</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/SHRLogo.png')}}" alt="SmartHR Logo">
        </div>
        <div class="navbar">
            <a href="{{route('admin.dashboardMain')}}">Home</a>
            <a href="{{route('admin.login')}}">Logout</a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-container">
            <div class="logo-cont">
                <img src="{{ asset('images/SHRLogo.png')}}" alt="SmartHR Logo">
            </div>
            <div class="column">
                <h3>Discover</h3>
                <ul class="lists">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">About Us</a></li>
                </ul>
            </div>
            <div class="column">
                <h3>Help</h3>
                <ul class="lists">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Partners</a></li>
                </ul>
            </div>
            <div class="column">
                <h3>About</h3>
                <ul class="lists">
                    <li><a href="#">Meet the Team</a></li>
                    <li><a href="#">Companies</a></li>
                    <li><a href="#">Testimonials</a></li>
                </ul>
            </div>
            <div class="column">
                <h2>SmartHR</h2>
                <h2>1428 Houndstreet</h2>
                <h2>Boston, MA 02115</h2>
                <ul class="socials">
                    <a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-twitter"></i></a><a href="#"><i class="bi bi-linkedin"></i></a><a href="#"><i class="bi bi-instagram"></i></a><a href="#"><i class="bi bi-envelope-at"></i></a>
                </ul>
            </div>
        </div>
        <hr>
        <p>© 2025 SmartHR. All rights reserved.</p>
    </footer>
</body>


</html>
