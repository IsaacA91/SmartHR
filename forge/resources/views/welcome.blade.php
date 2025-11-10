<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background-color: #F5F9FF;
        color: #4849E8;
        line-height: 1.6;
    }

    header {
        background-color: #4849E8;
        color: white;
        padding: 20px 40px;
        text-align: center;
    }

    .hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        background-color: #ABC4FF;
        padding: 80px 10%;
    }

    .hero-text {
        flex: 1 1 450px;
        max-width: 600px;
    }

    .hero-text h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #4849E8;
    }

    .hero-text p {
        font-size: 1.1rem;
        margin-bottom: 30px;
        color: #1a1a1a;
    }

    .hero-text button {
        background-color: #DDF344;
        border: none;
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .hero-text button:hover {
        transform: scale(1.05);
        background-color: #e7f863;
    }

    .hero-text a {
        text-decoration: none;
        color: #4849E8;
    }

    .hero-video {
        flex: 1 1 400px;
        text-align: center;
    }

    .hero-video video,
    .hero-video iframe {
        width: 100%;
        max-width: 500px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    section {
        padding: 80px 10%;
        text-align: center;
    }

    .devs {
        background-color: white;
        border-top: 4px solid #ABC4FF;
        border-bottom: 4px solid #ABC4FF;
    }

    .devs h2 {
        color: #4849E8;
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .devs p {
        max-width: 700px;
        margin: 0 auto;
        color: #333;
    }

    footer {
        background-color: #4849E8;
        color: white;
        text-align: center;
        padding: 20px 0;
        margin-top: 40px;
        font-size: 0.9rem;
    }
</style>
</head>
<html>
    <body>

<header>
    <h1>Welcome to Smart HR</h1>
</header>

<section class="hero">
    <div class="hero-text">
        <h1>Put workforce understanding to work</h1>
        <p>The workforce operating platform that empowers the front line and connects the front office with technology and insights to solve any challenge. In any moment. In every industry.</p>
        <button><a href="signinPage">Get Started</a></button>
    </div>

    <div class="hero-video">
        <video controls muted poster="thumbnail.jpg">
            <source src="intro.mp4" type="video/mp4">
            Sorry, your browser doesn’t support embedded videos.
        </video>
    </div>
</section>

<section class="devs">
    <h2>Made with hard work by our developers</h2>
    <p>Our team poured their dedication into building a powerful and user-friendly HR platform designed to empower organizations worldwide.</p>
    <div class="developer">
     <img src="{{ asset('pictures/Evin.webp') }}" alt="Evin" width="200">
      <h3>Evin Camacho</h3>
      <p>Programmer</p>
    </div>

</section>

<section>
    <h2>Reviews</h2>
    <p>See what people are saying about Smart HR.</p>
</section>

<footer>
    <p>© 2025 Smart HR. All rights reserved.</p>
</footer>

</body>
</html>
