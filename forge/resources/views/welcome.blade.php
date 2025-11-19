<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8">
    <title>Smart HR | Home</title>
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

    .developers-section {
  text-align: center;
  background-color: #F5F9FF;
  padding: 60px 20px;
}

.developers-section h2 {
  color: #4849E8;
  font-size: 2em;
  margin-bottom: 40px;
}

.devCards {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 40px;
}

.developer {
  background: #ABC4FF;
  border-radius: 20px;
  padding: 20px;
  width: 220px;
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  transition: transform 0.3s;
}

.developer:hover {
  transform: translateY(-8px);
}

.developer img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #DDF344;
  margin-bottom: 15px;
}

.developer h3 {
  color: #4849E8;
  margin-bottom: 5px;
}

.developer p {
  color: #ffffff;
  font-weight: bold;
}

    footer {
        background-color: #4849E8;
        color: white;
        text-align: center;
        padding: 20px 0;
        margin-top: 40px;
        font-size: 0.9rem;     
    }

    .reviews {
  background-color: #F5F9FF;
  text-align: center;
  padding: 60px 20px;
}

.reviews h2 {
  font-size: 2em;
  color: #4849E8;
}

.reviews h3 {
  color: #555;
  margin-bottom: 40px;
}

.revCards {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 40px;
}

.review {
  background: white;
  border-radius: 12px;
  padding: 30px 20px;
  width: 280px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.review:hover {
  transform: translateY(-5px);
}

.review img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #ABC4FF;
  margin-bottom: 15px;
}

.review h3 {
  color: #4849E8;
  font-size: 1.2em;
  margin-bottom: 10px;
}

.review p {
  color: #333;
  font-style: italic;
}

@media (max-width: 768px) {
  .reviewCards {
    flex-direction: column;
    align-items: center;
  }
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
        <h1>Use SmartHr to manage work</h1>
        <p>A workface operating system that will make work life feasible, understandable and better. </p>
        <button><a href="signinPage">Get Started</a></button>
    </div>

    <div class="hero-video">
        <video autoplay muted loop playsinline poster="{{ asset('images/thumbnail.jpg') }}">
           <source src="{{ asset('videos/Hrvideo.mp4') }}" type="video/mp4">
           
        </video>
    </div>
</section>

<section class="devs">
    <h2>Made with hard work by our developers</h2>
    <p>Our team poured their dedication into building a powerful and user-friendly HR platform designed to empower organizations worldwide.</p>
    <div class='devCards'>
    <div class="developer">
     <img src="{{ asset('pictures/Evin.webp') }}" alt="Evin" width="200">
      <h3>Evin Camacho</h3>
      <p>Programmer</p>
    </div>
    <div class="developer">
     <img src="{{ asset('pictures/Evin.webp') }}" alt="Evin" width="200">
      <h3>Evin Camacho</h3>
      <p>Programmer</p>
    </div>
    <div class="developer">
     <img src="{{ asset('pictures/Evin.webp') }}" alt="Evin" width="200">
      <h3>Evin Camacho</h3>
      <p>Programmer</p>
    </div>
    <div class="developer">
     <img src="{{ asset('pictures/Evin.webp') }}" alt="Evin" width="200">
      <h3>Evin Camacho</h3>
      <p>Programmer</p>
    </div>
</div>

</section>

<section>
    <h2>Reviews</h2>
    <h3>See what people are saying about Smart HR.</h3>
    <div class='revCards'> 
        <div class='review'>
            <img src="{{ asset('pictures/review1.webp') }}" alt="Jeff Bezos">
            <h3>Jeff Bezos</h3>
            <p> "Fully optimized our company"</p>
        </div>

         <div class='review'>
             <img src="{{ asset('pictures/images.jpg') }}" alt=" Mark Zuckerberg ">
            <h3> Mark Zuckerberg</h3>
            <p> "Cut costs on vacation for employees" </p>
        </div>

        <div class='review'>
             <img src="{{ asset('pictures/LarryFink.jpg') }}" alt=" Mark Zuckerberg ">
            <h3> Mark Zuckerberg</h3>
            <p> "Cut costs on vacation for employees" </p>
        </div>
    </div>
</section>

<footer>
    <p>© 2025 Smart HR. All rights reserved.</p>
</footer>

</body>
</html>
