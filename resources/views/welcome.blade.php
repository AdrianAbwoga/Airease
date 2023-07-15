
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Airease</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

                    <!-- 
                - favicon
            -->
            <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

            <!-- 
            - custom css link
            -->
            <<link rel="stylesheet" href="{{ asset('css/style.css') }}">

            <script src="{{ asset('js/script.js') }}"></script>

            <!-- 
            - google font link
            -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
            rel="stylesheet">
       
    </head>
    <body class="antialiased">

  <header class="header" data-header>

<div class="overlay" data-overlay></div>

<div class="header-top">
  <div class="container">

    <a href="" class="helpline-box">

      

    </a>

    <a href="#" class="logo">
    <img src="{{ asset('logo/mainlogo.png') }}" alt="Airease logo">
      
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

    <ul class="social-list">

      <li>
        <a href="#" class="social-link">
          <ion-icon name="logo-facebook"></ion-icon>
        </a>
      </li>

      <li>
        <a href="#" class="social-link">
          <ion-icon name="logo-twitter"></ion-icon>
        </a>
      </li>

      <li>
        <a href="#" class="social-link">
          <ion-icon name="logo-youtube"></ion-icon>
        </a>
      </li>

    </ul>

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
    
    

    <button class="btn btn-primary" onclick="window.location.href=''">Book Now</button>

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
        <button class="btn btn-primary">Learn more</button>

        <button class="btn btn-secondary" onclick="window.location.href=''">Book now</button>
      </div>

    </div>
  </section>



  <!-- 
    - #POPULAR
  -->

  <section class="popular" id="destination">
    <div class="container">

      <p class="section-subtitle">Where To Go</p>

      <h2 class="h2 section-title">Popular destination</h2>

      <p class="section-text">
        Fusce hic augue velit wisi quibusdam pariatur, iusto primis, nec nemo, rutrum. Vestibulum cumque laudantium.
        Sit ornare
        mollitia tenetur, aptent.
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
              <img src="{{ asset('images/egypt.jpg') }}" alt="Pyramids of Giza, egypt" loading="lazy">
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

      <button class="btn btn-primary">More destintion</button>

    </div>
  </section>





  <!-- 
    - #fights Servives
  -->

  <section class="package" id="package">
    <div class="container">

      <p class="section-subtitle">Popular Airlines</p>

      <h2 class="h2 section-title">Choose your Flight</h2>

      <p class="section-text">
        Fusce hic augue velit wisi quibusdam pariatur, iusto primis, nec nemo, rutrum. Vestibulum cumque laudantium.
        Sit ornare
        mollitia tenetur, aptent.
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
                Laoreet, voluptatum nihil dolor esse quaerat mattis explicabo maiores, est aliquet porttitor! Eaque,
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

              <button class="btn btn-secondary">Book Now</button>

            </div>

          </div>
        </li>

        <li>
          <div class="package-card">

            <figure class="card-banner">
              <img src="{{ asset('images/rw.png') }}"   loading="lazy">
            </figure>

            <div class="card-content">

              <h3 class="h3 card-title">A trip with Rwandair</h3>

              <p class="card-text">
                Laoreet, voluptatum nihil dolor esse quaerat mattis explicabo maiores, est aliquet porttitor! Eaque,
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

              <button class="btn btn-secondary">Book Now</button>

            </div>

          </div>
        </li>

        <li>
          <div class="package-card">

            <figure class="card-banner">
              <img src="{{ asset('images/sa.png') }}"  loading="lazy">
            </figure>

            <div class="card-content">

              <h3 class="h3 card-title">What the South African Airways will offer</h3>

              <p class="card-text">
                Laoreet, voluptatum nihil dolor esse quaerat mattis explicabo maiores, est aliquet porttitor! Eaque,
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

              <button class="btn btn-secondary">Book Now</button>

            </div>

          </div>
        </li>

      </ul>

      <button class="btn btn-primary">View All Flights</button>

    </div>
  </section>





  <!-- 
    - #Plan your Travel
  -->

  <section class="gallery" id="gallery">
    <div class="container">

      <p class="section-subtitle">What More</p>

      <h2 class="h2 section-title">Plan Your Travel</h2>

      <p class="section-text">
        Fusce hic augue velit wisi quibusdam pariatur, iusto primis, nec nemo, rutrum. Vestibulum cumque laudantium.
        Sit ornare
        mollitia tenetur, aptent.
      </p>

      <div class="horizontal-container">
        <div class="box">
          <img src="{{ asset('images/BMW-2-Series-Gran-Coupe-271220221147.jpg') }}"alt="Car Image">
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





  <!-- 
    - #CTA
  -->

  <section class="cta" id="contact">
    <div class="container">

      <div class="cta-content">
        <p class="section-subtitle">What's Up</p>

        <h2 class="h2 section-title">Ready For Unforgatable Travel. Remember Us!</h2>

        <p class="section-text">
          Fusce hic augue velit wisi quibusdam pariatur, iusto primis, nec nemo, rutrum. Vestibulum cumque
          laudantium. Sit ornare
          mollitia tenetur, aptent.
        </p>
      </div>

      <button class="btn btn-secondary">Contact Us</button>

    </div>
  </section>

</article>
</main>





<!-- 
- #FOOTER
-->

<footer class="footer">

<div class="footer-top">
  <div class="container">

    <div class="footer-brand">

      <a href="#" class="logo">
        <img src="{{ asset('images/logoblue.svg') }}"  alt="airease logo">
      </a>

      <p class="footer-text">
        Urna ratione ante harum provident, eleifend, vulputate molestiae proin fringilla, praesentium magna conubia
        at
        perferendis, pretium, aenean aut ultrices.
      </p>

    </div>

    <div class="footer-contact">

      <h4 class="contact-title">Contact Us</h4>

      <p class="contact-text">
        Feel free to contact and reach us !!
      </p>

      <ul>

        <li class="contact-item">
          <ion-icon name="call-outline"></ion-icon>

          <a href="tel:+01123456790" class="contact-link">+254 701452662 / +254 705437676</a>
        </li>

        <li class="contact-item">
          <ion-icon name="mail-outline"></ion-icon>

          <a href="mailto:info.airease.com" class="contact-link">info.airease.com</a>
        </li>

        <li class="contact-item">
          <ion-icon name="location-outline"></ion-icon>

          <address>00100 Nairobi, Kenya</address>
        </li>

      </ul>

    </div>

    <div class="footer-form">

      <p class="form-text">
        Subscribe our newsletter for more update & news !!
      </p>

      <form action="" class="form-wrapper">
        <input type="email" name="email" class="input-field" placeholder="Enter Your Email" required>

        <button type="submit" class="btn btn-secondary">Subscribe</button>
      </form>

    </div>

  </div>
</div>

<div class="footer-bottom">
  <div class="container">

    <p class="copyright">
      &copy; 2023 <a href="">airease</a>. All rights reserved
    </p>

    <ul class="footer-bottom-list">

      <li>
        <a href="#" class="footer-bottom-link">Privacy Policy</a>
      </li>

      <li>
        <a href="#" class="footer-bottom-link">Term & Condition</a>
      </li>

      <li>
        <a href="#" class="footer-bottom-link">FAQ</a>
      </li>

    </ul>

  </div>
</div>

</footer>





<!-- 
- #GO TO TOP
-->

<a href="#top" class="go-top" data-go-top>
<ion-icon name="chevron-up-outline"></ion-icon>
</a>





<!-- 
- custom js link
-->
<script src="./assets/js/script.js"></script>

<!-- 
- ionicon link
-->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


            
            

                

                
            </div>
        </div>
    </body>
</html>