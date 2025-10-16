<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Awaiken">
    <!-- Page Title -->
    <title>Inspaire - Architecture and Interior Design HTML Template</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- Google Fonts Css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/landing-pages/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
    <!-- SlickNav Css -->
    <link href="{{ asset('assets/landing-pages/css/slicknav.min.css') }}" rel="stylesheet">
    <!-- Swiper Css -->
    <link href="{{ asset('assets/landing-pages/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <!-- Font Awesome Icon Css-->
    <link href="{{ asset('assets/landing-pages/css/all.min.css') }}" rel="stylesheet" media="screen">
    <!-- Animated Css -->
    <link href="{{ asset('assets/landing-pages/css/animate.css') }}" rel="stylesheet">
    <!-- Magnific Popup Core Css File -->
    <link href="{{ asset('assets/landing-pages/css/magnific-popup.css') }}" rel="stylesheet">
    <!-- Mouse Cursor Css File -->
    <link href="{{ asset('assets/landing-pages/css/mousecursor.css') }}" rel="stylesheet">
    <!-- Main Custom Css -->
    <link href="{{ asset('assets/landing-pages/css/custom.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    <!-- Preloader Start -->
    <div class="preloader">
        <div class="loading-container">
            <div class="loading"></div>
            <div id="loading-icon"><img src="{{ asset('assets/landing-pages/images/loader.svg') }}" alt="">
            </div>
        </div>
    </div>
    <!-- Preloader End -->

    <!-- Header Start -->
    <header class="main-header">
        <div class="header-sticky">
            <nav class="container">
                <div class="navbar navbar-expand-lg">
                    <!-- Logo Start -->
                    <a class="navbar-brand" href="./">
                        <img src="{{ asset('assets/landing-pages/images/logo.svg') }}" alt="Logo">
                    </a>
                    <!-- Logo End -->

                    <!-- Main Menu Start -->
                    <div class="collapse navbar-collapse main-menu">
                        <div class="nav-menu-wrapper">
                            <ul class="navbar-nav mr-auto" id="menu">
                                <li class="nav-item submenu"><a class="nav-link" href="./">Home</a>
                                    <ul>
                                        <li class="nav-item"><a class="nav-link" href="index.html">Home - Image</a></li>
                                        <li class="nav-item"><a class="nav-link" href="index-video.html">Home -
                                                Video</a></li>
                                        <li class="nav-item"><a class="nav-link" href="index-slider.html">Home -
                                                Slider</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="about.html">About Us</a>
                                <li class="nav-item"><a class="nav-link" href="services.html">Services</a></li>
                                <li class="nav-item"><a class="nav-link" href="projects.html">Projects</a></li>
                                <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                                <li class="nav-item submenu"><a class="nav-link" href="#">Pages</a>
                                    <ul>
                                        <li class="nav-item"><a class="nav-link" href="service-single.html">Service
                                                Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="project-single.html">Project
                                                Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="blog-single.html">Blog
                                                Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="image-gallery.html">Image
                                                Gallery</a></li>
                                        <li class="nav-item"><a class="nav-link" href="faqs.html">FAQs</a></li>
                                        <li class="nav-item"><a class="nav-link" href="404.html">404</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                            </ul>
                        </div>
                        <!-- Header Btn Start -->
                        <div class="header-btn d-inline-flex">
                            <a href="contact.html" class="btn-default">get in touch</a>
                        </div>
                        <!-- Header Btn End -->
                    </div>
                    <!-- Main Menu End -->
                    <div class="navbar-toggle"></div>
                </div>
            </nav>
            <div class="responsive-menu"></div>
        </div>
    </header>

    <div class="page-header parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Residential design</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">home</a></li>
                                <li class="breadcrumb-item"><a href="services.html">services</a></li>
                                <li class="breadcrumb-item active" aria-current="page">residential design</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>


    @yield('content')



    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Footer Header Start -->
                    <div class="footer-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <!-- Footer Logo Start -->
                                <div class="footer-logo">
                                    <img src="{{ asset('assets/landing-pages/images/footer-logo.svg') }}"
                                        alt="">
                                </div>
                                <!-- Footer Logo End -->
                            </div>

                            <div class="col-md-6">
                                <!-- Footer Social Link Start -->
                                <div class="footer-social-links">
                                    <div class="footer-social-link-title">
                                        <h3>follow our socials</h3>
                                    </div>
                                    <ul>
                                        <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-dribbble"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                                <!-- Footer Social Link End -->
                            </div>
                        </div>
                    </div>
                    <!-- Footer Header End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Footer Links Start -->
                    <div class="footer-links">
                        <h3>information</h3>
                        <ul>
                            <li><a href="about.html">about our company</a></li>
                            <li><a href="services.html">view our service</a></li>
                            <li><a href="#">careers at company</a></li>
                            <li><a href="blog.html">read our blog</a></li>
                            <li><a href="projects.html">our latest projects</a></li>
                        </ul>
                    </div>
                    <!-- Footer Links End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Footer Links Start -->
                    <div class="footer-links">
                        <h3>portfolio</h3>
                        <ul>
                            <li><a href="project-single.html">luxury home design</a></li>
                            <li><a href="project-single.html">residential interior design</a></li>
                            <li><a href="project-single.html">commercial space design</a></li>
                            <li><a href="project-single.html">residential interior design</a></li>
                            <li><a href="project-single.html">renovation and restoration design</a></li>
                        </ul>
                    </div>
                    <!-- Footer Links End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Footer Contact Box Start -->
                    <div class="footer-contact-box footer-links">
                        <h3>contact us</h3>
                        <!-- Footer Contact Item Start -->
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="footer-contact-content">
                                <p>+1 (213) 465 789</p>
                            </div>
                        </div>
                        <!-- Footer Contact Item End -->

                        <!-- Footer Contact Item Start -->
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="footer-contact-content">
                                <p>info@domain.com</p>
                            </div>
                        </div>
                        <!-- Footer Contact Item End -->

                        <!-- Footer Contact Item Start -->
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="footer-contact-content">
                                <p>Generała Ziętka Jerzego 54, Mysłowice 41-412</p>
                            </div>
                        </div>
                        <!-- Footer Contact Item End -->
                    </div>
                    <!-- Footer Contact Box End -->
                </div>

                <div class="col-lg-3 col-md-6">
                    <!-- Footer Newsletter Form Start -->
                    <div class="footer-latest-news footer-links">
                        <h3>get the latest trending news</h3>

                        <div class="footer-newsletter-form">
                            <p>Your Dream Space Starts Here Get Exclusive Design Straight Your Inbox!</p>

                            <form id="newslettersForm" action="#" method="POST">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" id="mail"
                                        placeholder="Enter your email" required>
                                    <button type="submit"><i class="fa-solid fa-arrow-right-long"></i> </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Footer Newsletter Form End -->
                </div>
            </div>

            <!-- Footer Copyright Section Start -->
            <div class="footer-copyright">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Footer Copyright Start -->
                        <div class="footer-copyright-text">
                            <p>Copyright © 2024 All Rights Reserved.</p>
                        </div>
                        <!-- Footer Copyright End -->
                    </div>
                </div>
            </div>
            <!-- Footer Copyright Section End -->
        </div>
    </footer>
    <!-- Footer End -->

    <!-- Jquery Library File -->
    <!-- jQuery -->
    <script src="{{ asset('assets/landing-pages/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap js file -->
    <script src="{{ asset('assets/landing-pages/js/bootstrap.min.js') }}"></script>

    <!-- Validator js file -->
    <script src="{{ asset('assets/landing-pages/js/validator.min.js') }}"></script>

    <!-- SlickNav js file -->
    <script src="{{ asset('assets/landing-pages/js/jquery.slicknav.js') }}"></script>

    <!-- Swiper js file -->
    <script src="{{ asset('assets/landing-pages/js/swiper-bundle.min.js') }}"></script>

    <!-- Counter js file -->
    <script src="{{ asset('assets/landing-pages/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/landing-pages/js/jquery.counterup.min.js') }}"></script>

    <!-- Isotope js file -->
    <script src="{{ asset('assets/landing-pages/js/isotope.min.js') }}"></script>

    <!-- Magnific Popup js file -->
    <script src="{{ asset('assets/landing-pages/js/jquery.magnific-popup.min.js') }}"></script>

    <!-- SmoothScroll -->
    <script src="{{ asset('assets/landing-pages/js/SmoothScroll.js') }}"></script>

    <!-- Parallax js -->
    <script src="{{ asset('assets/landing-pages/js/parallaxie.js') }}"></script>

    <!-- MagicCursor js file -->
    <script src="{{ asset('assets/landing-pages/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/landing-pages/js/magiccursor.js') }}"></script>

    <!-- Text Effect js file -->
    <script src="{{ asset('assets/landing-pages/js/SplitText.js') }}"></script>
    <script src="{{ asset('assets/landing-pages/js/ScrollTrigger.min.js') }}"></script>

    <!-- YTPlayer js File -->
    <script src="{{ asset('assets/landing-pages/js/jquery.mb.YTPlayer.min.js') }}"></script>

    <!-- Wow js file -->
    <script src="{{ asset('assets/landing-pages/js/wow.min.js') }}"></script>

    <!-- Main Custom js file -->
    <script src="{{ asset('assets/landing-pages/js/function.js') }}"></script>

</body>

</html>
