<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Airease</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('logo/mainlogo.png') }}" type="image/svg+xml">
    <!-- custom css link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/script.js') }}"></script>
    <!-- google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased">
    <header class="header" data-header>
        <div class="overlay" data-overlay></div>
        <div class="header-top">
            <div class="container">
                <a href="" class="helpline-box"></a>
                <a href="#" class="logo">
                    <img src="" alt="">
                </a>
                <div class="header-btn-group">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/user/dashboard') }}" class="dashboard">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="login">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="reg">Register</a>
                            @endif
                        @endauth
                    @endif
                    <button class="nav-open-btn" aria-label="Open Menu" data-nav-open-btn>
                        <ion-icon name="menu-outline"></ion-icon>
                    </button>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                
                <nav class="navbar" data-navbar>
                    <div class="navbar-top">
                        <a href="#" class="logo">
                            <img src="{{ asset('images/logoblue.svg') }}" alt="Airease logo">
                        </a>
                        <button class="nav-close-btn" aria-label="Close Menu" data-nav-close-btn>
                            <ion-icon name="close-outline"></ion-icon>
                        </button>
                    </div>
                    
                    <ul class="navbar-list">
                        <li>
                            <a href="#home" class="navbar-link" data-nav-link>Home</a>
                        </li>
                        <li>
                            <a href="#destination" class="navbar-link" data-nav-link>Destination</a>
                        </li>
                        <li>
                            <a href="#package" class="navbar-link" data-nav-link>Flight</a>
                        </li>
                        <li>
                            <a href="#gallery" class="navbar-link" data-nav-link>Plan your Travel</a>
                        </li>
                        <li>
                            <a href="#contact" class="navbar-link" data-nav-link>contact us</a>
                        </li>
                    </ul>
                </nav>
                

            </div>
        </div>
    </header>
    <main>
        <article>
            <section class="hero" id="home">
                <div class="container">
                    <h2 class="h1 hero-title">Journey to explore the world</h2>
                    <p class="hero-text">
                        Ac mi duis mollis. Sapiente? Scelerisque quae, penatibus? Suscipit class corporis nostra rem quos
                        voluptatibus habitant?
                        Fames, vivamus minim nemo enim, gravida lobortis quasi, eum.
                    </p>
                    <div class="btn-group">
                        
                        <button class="btn btn-primary" onclick="window.location.href='{{ route('login') }}'">Book Now</button>
                    </div>
                </div>
            </section>
            <section class="popular" id="destination">
                <div class="container">
                    <p class="section-subtitle">Where To Go</p>
                    <h2 class="h2 section-title">Popular destination</h2>
                    <p class="section-text">
                        Fusce hic augue velit wisi quibusdam pariatur, iusto primis, nec nemo, rutrum. Vestibulum cumque
                        laudantium.
                        Sit ornare mollitia tenetur, aptent.
                    </p>
                    <ul class="popular-list">
                        <li>
                            <div class="popular-card">
                                <figure class="card-img">
                                    <img src="{{ asset('images/diani.png') }}" alt="Diani Beach, Kenya" loading="lazy">
                                </figure>
                                <div class="card-content">
                                    <p class="card-subtitle">
                                        <a href="#">Kenya</a>
                                    </p>
                                    <h3 class="h3 card-title">
                                        <a href="#">Diani Beach</a>
                                    </h3>
                                    <p class="card-text">
                                        Fusce hic augue velit wisi ips quibusdam pariatur, iusto.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="popular-card">
                                <figure class="card-img">
                                    <img src="{{ asset('images/egypt.jpg') }}" alt="Pyramids of Giza, Egypt" loading="lazy">
                                </figure>
                                <div class="card-content">
                                    <p class="card-subtitle">
                                        <a href="#">Egypt</a>
                                    </p>
                                    <h3 class="h3 card-title">
                                        <a href="#">Pyramids of Giza</a>
                                    </h3>
                                    <p class="card-text">
                                        Fusce hic augue velit wisi ips quibusdam pariatur, iusto.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="popular-card">
                                <figure class="card-img">
                                    <img src="{{ asset('images/SA.jpg') }}" alt="Table Mountain, South Africa" loading="lazy">
                                </figure>
                                <div class="card-content">
                                    <p class="card-subtitle">
                                        <a href="#">South Africa</a>
                                    </p>
                                    <h3 class="h3 card-title">
                                        <a href="#">Table Mountain</a>
                                    </h3>
                                    <p class="card-text">
                                        Fusce hic augue velit wisi ips quibusdam pariatur, iusto.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                </div>
            </section>
            <section class="package" id="package">
                <div class="container">
                    <p class="section-subtitle">Popular Airlines</p>
                    <h2 class="h2 section-title">Choose your Flight</h2>
                    <p class="section-text">
                        Fusce hic augue velit wisi quibusdam pariatur, iusto primis, nec nemo, rutrum. Vestibulum cumque
                        laudantium.
                        Sit ornare mollitia tenetur, aptent.
                    </p>
                    <ul class="package-list">
                        <li>
                            <div class="package-card">
                                <figure class="card-banner">
                                    <img src="{{ asset('images/kq.png') }}" loading="lazy">
                                </figure>
                                <div class="card-content">
                                    <h3 class="h3 card-title">The Kenya Airways Experience</h3>
                                    <p class="card-text">
                                        Laoreet, voluptatum nihil dolor esse quaerat mattis explicabo maiores, est aliquet
                                        porttitor! Eaque,
                                        cras, aspernatur.
                                    </p>
                                    <ul class="card-meta-list">
                                        <li class="card-meta-item">
                                            <div class="meta-box">
                                                <ion-icon name="time"></ion-icon>
                                                <p class="text">24/7</p>
                                            </div>
                                        </li>
                                        <li class="card-meta-item">
                                            <div class="meta-box">
                                                <ion-icon name="location"></ion-icon>
                                                <p class="text">Nairobi</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-price">
                                    <div class="wrapper">
                                        <p class="reviews">(25 reviews)</p>
                                        <div class="card-rating">
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="package-card">
                                <figure class="card-banner">
                                    <img src="{{ asset('images/rw.png') }}" loading="lazy">
                                </figure>
                                <div class="card-content">
                                    <h3 class="h3 card-title">A trip with Rwandair</h3>
                                    <p class="card-text">
                                        Laoreet, voluptatum nihil dolor esse quaerat mattis explicabo maiores, est aliquet
                                        porttitor! Eaque,
                                        cras, aspernatur.
                                    </p>
                                    <ul class="card-meta-list">
                                        <li class="card-meta-item">
                                            <div class="meta-box">
                                                <ion-icon name="time"></ion-icon>
                                                <p class="text">24/7</p>
                                            </div>
                                        </li>
                                        <li class="card-meta-item">
                                            <div class="meta-box">
                                                <ion-icon name="location"></ion-icon>
                                                <p class="text">Kigali</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-price">
                                    <div class="wrapper">
                                        <p class="reviews">(20 reviews)</p>
                                        <div class="card-rating">
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="package-card">
                                <figure class="card-banner">
                                    <img src="{{ asset('images/sa.png') }}" loading="lazy">
                                </figure>
                                <div class="card-content">
                                    <h3 class="h3 card-title">What the South African Airways will offer</h3>
                                    <p class="card-text">
                                        Laoreet, voluptatum nihil dolor esse quaerat mattis explicabo maiores, est aliquet
                                        porttitor! Eaque,
                                        cras, aspernatur.
                                    </p>
                                    <ul class="card-meta-list">
                                        <li class="card-meta-item">
                                            <div class="meta-box">
                                                <ion-icon name="time"></ion-icon>
                                                <p class="text">24/7</p>
                                            </div>
                                        </li>
                                        <li class="card-meta-item">
                                            <div class="meta-box">
                                                <ion-icon name="location"></ion-icon>
                                                <p class="text">Malaysia</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-price">
                                    <div class="wrapper">
                                        <p class="reviews">(40 reviews)</p>
                                        <div class="card-rating">
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                            <ion-icon name="star"></ion-icon>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                </div>
            </section>
            <section class="gallery" id="gallery">
                <div class="container">
                    <p class="section-subtitle">What More</p>
                    <h2 class="h2 section-title">Plan Your Travel</h2>
                    <p class="section-text">
                        Fusce hic augue velit wisi quibusdam pariatur, iusto primis, nec nemo, rutrum. Vestibulum cumque
                        laudantium.
                        Sit ornare mollitia tenetur, aptent.
                    </p>
                    <div class="horizontal-container">
                        <div class="box">
                            <img src="{{ asset('images/BMW-2-Series-Gran-Coupe-271220221147.jpg') }}" alt="Car Image">
                            <h2>Car Booking</h2>
                            <p>Book a car for your travel needs.</p>
                        </div>
                        <div class="box">
                            <img src="{{ asset('images/download.jfif') }}" alt="Hotel Image">
                            <h2>Hotel Booking</h2>
                            <p>Find and book hotels for your stay.</p>
                        </div>
                        <div class="box">
                            <img src="{{ asset('images/tour.jfif') }}" alt="Tour Agent Image">
                            <h2>Tour Agents</h2>
                            <p>Discover expert tour agents for personalized travel experiences.</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="cta" id="contact">
                <div class="container">
                    <div class="cta-content">
                        <p class="section-subtitle">What's Up</p>
                        <h2 class="h2 section-title">Ready For Unforgettable Travel. Remember Us!</h2>
                        <p class="section-text">
                            Fusce hic augue velit wisi quibusdam pariatur, iusto primis, nec nemo, rutrum. Vestibulum cumque
                            laudantium. Sit ornare
                            mollitia tenetur, aptent.
                        </p>
                    </div>
                    
                </div>
            </section>
        </article>
    </main>
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-brand">
                    <a href="#" class="logo">
                        <img src="{{ asset('images/logoblue.svg') }}" alt="Airease logo">
                    </a>
                    <p class="footer-text">
                        Urna ratione ante harum provident, eleifend, vulputate molestiae proin fringilla, praesentium magna conubia
                        at
                        perferendis, pretium, aenean aut ultrices numquam.
                    </p>
                </div>
                <div class="footer-contact">
                    <h3 class="footer-heading">Contact Us</h3>
                    <ul class="contact-list">
                        <li>
                            <ion-icon name="location-outline"></ion-icon>
                            <p class="text">123 Street, City, Country</p>
                        </li>
                        <li>
                            <ion-icon name="call-outline"></ion-icon>
                            <p class="text">+123 456 789</p>
                        </li>
                        <li>
                            <ion-icon name="mail-outline"></ion-icon>
                            <p class="text">info@example.com</p>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p class="text">© 2023 Airease. All Rights Reserved.</p>
                
            </div>
        </div>
    </footer>
</body>
</html>
