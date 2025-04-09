<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="تسوق منتجات بر الليث - ملابس أطفال عالية الجودة، تصاميم عصرية، وخامات ممتازة. منتجات متميزة بأسعار مناسبة في محافظة الليث التابعة لمكة المكرمة.">
    <meta name="keywords" content="بر الليث، ملابس أطفال، مصنع ملابس، ملابس عصرية، ملابس أطفال جودة عالية، محافظة الليث، مكة المكرمة">
    <meta name="author" content="بر الليث">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Open Graph Meta Tags -->
    <meta property="og:site_name" content="بر الليث">
    <meta property="og:title" content="متجر بر الليث | ملابس أطفال عالية الجودة في محافظة الليث">
    <meta property="og:description" content="تسوق منتجات بر الليث - ملابس أطفال عالية الجودة، تصاميم عصرية، وخامات ممتازة. منتجات متميزة بأسعار مناسبة في محافظة الليث التابعة لمكة المكرمة.">
    <meta property="og:image" content="/assets/images/logo.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ar_SA">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="متجر بر الليث | ملابس أطفال عالية الجودة في محافظة الليث">
    <meta name="twitter:description" content="تسوق منتجات بر الليث - ملابس أطفال عالية الجودة، تصاميم عصرية، وخامات ممتازة. منتجات متميزة بأسعار مناسبة في محافظة الليث التابعة لمكة المكرمة.">
    <meta name="twitter:image" content="/assets/images/logo.png">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>متجر بر الليث | من نحن</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!--   <link rel="stylesheet" href="font/ElegantIcons.ttf">
 -->


    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/font-awesome.min.css') }}" type="text/css">
 <!--    <link rel="stylesheet" href="css2/elegant-icons.css" type="text/css"> -->
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/style.css') }}" type="text/css">
</head>

<body>
    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <a href="Signup.html">Sign in</a>
                <a href="#">FAQs</a>
            </div>
            <div class="offcanvas__top__hover">
                <span>Usd <i class="arrow_carrot-down"></i></span>
                <ul>
                    <li>USD</li>
                    <li>EUR</li>
                    <li>USD</li>
                </ul>
            </div>
        </div>
        <div class="offcanvas__nav__option">
            <a href="#" class="search-switch"><img src="img/icon/search.png" alt=""></a>
            <a href="#"><img src="img/icon/heart.png" alt=""></a>
            <a href="#"><img src="img/icon/cart.png" alt=""> <span>0</span></a>
            <div class="price">$0.00</div>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__text">
            <p>Free shipping, 30-day return or refund guarantee.</p>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/kids-clothes/img/logo.png') }}" alt="E-Commerce Logo" height="60">
                </a>

                <!-- Toggler/collapsible Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('services') }}">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        </li>
                    </ul>

                    <!-- Right-side Icons -->
                    <div class="navbar-nav ml-auto">
                        <a href="#" class="nav-link"><i class="fa fa-heart"></i></a>
                        <a href="#" class="nav-link cart-icon" id="cart-icon">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="cart-count">0</span>
                        </a>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="Login.html">Login</a>
                                <a class="dropdown-item" href="Signup.html">Sign Up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Header Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>About Us</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <span>About Us</span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

   <!-- About Section Begin -->
<section class="about spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about__image">
                    <img src="{{ asset('assets/kids-clothes/img/about/clothes-wooden-table.jpg') }}" alt="About Us">
                    <img src="img/about/clothes-wooden-table.jpg" alt="About Us">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__content">
                    <h2>Who We Are</h2>
                    <p>We are a leading e-commerce brand specializing in premium-quality fashion for all ages. Our journey started with a mission to provide stylish and affordable clothing, ensuring customer satisfaction and top-notch quality.</p>

                    <h2>What We Do</h2>
                    <p>Our collection features handpicked, high-quality materials that blend fashion with comfort. We work with top designers and manufacturers to bring you the latest trends at unbeatable prices.</p>

                    <h2>Why Choose Us?</h2>
                    <ul class="about__list">
                        <li><i class="fa fa-check-circle"></i> High-quality, stylish clothing</li>
                        <li><i class="fa fa-check-circle"></i> Secure & fast shopping experience</li>
                        <li><i class="fa fa-check-circle"></i> 30-day easy returns & exchanges</li>
                        <li><i class="fa fa-check-circle"></i> Dedicated customer support</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->



<!-- Side Cart Section -->
<div class="side-cart">
    <div class="cart-header">
        <h4>Your Cart</h4>
        <button class="close-cart">&times;</button>
    </div>
    <div class="cart-items">
        <!-- Cart items will be dynamically added here -->
    </div>
    <div class="cart-footer">
        <p>Total: <span id="cart-total">$0.00</span></p>
        <a href="checkout.html" class="checkout-btn">Checkout</a>
    </div>
</div>


<!-- Wishlist Sidebar Section -->
<div class="side-wishlist">
    <div class="wishlist-header">
        <h4>Your Wishlist</h4>
        <button class="close-wishlist">&times;</button>
    </div>
    <div class="wishlist-items">
        <!-- Wishlist items will be dynamically added here -->
    </div>
    <div class="wishlist-footer">
        <a href="My wishlist.html" class="view-wishlist-btn">View Wishlist</a>
    </div>
</div>
<div class="wishlist-overlay"></div>



    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#"><img src="img/logo.png" width="100" height="150" alt=""></a>
                        </div>
                        <p>The customer is at the heart of our unique business model, which includes design.</p>
                        <a href="#"><img src="img/payment.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Clothing Store</a></li>
                            <li><a href="#">Trending Shoes</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Sale</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Payment Methods</a></li>
                            <li><a href="#">Delivary</a></li>
                            <li><a href="#">Return & Exchanges</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>NewLetter</h6>
                        <div class="footer__newslatter">
                            <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                            <form action="#">
                                <input type="text" placeholder="Your email">
                                <button type="submit"><span class="icon_mail_alt"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Js Plugins -->
    <script src="{{ asset('assets/kids-clothes/js2/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/kids-clothes/js2/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/kids-clothes/js2/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/kids-clothes/js2/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/kids-clothes/js2/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/kids-clothes/js2/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/kids-clothes/js2/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/kids-clothes/js2/mixitup.min.js') }}"></script>
    <script src="{{ asset('assets/kids-clothes/js2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/kids-clothes/js2/main.js') }}"></script>



    <script>
      ////
document.addEventListener("DOMContentLoaded", function () {
    updateNavbar();
});


function updateNavbar() {
    const user = JSON.parse(localStorage.getItem("user"));
    const navIcons = document.querySelector(".nav-icons");

    if (user) {
        // If user is logged in, show Profile and Logout
        navIcons.innerHTML = `
            <a href="wishlist.html" class="nav-icon"><i class="fa fa-heart"></i></a>
            <a href="#" class="nav-icon cart-icon" id="cart-icon">
                <i class="fa fa-shopping-cart"></i>
                <span class="cart-count">0</span>
            </a>
            <div class="user-dropdown">
                <button class="user-btn"><i class="fa fa-user"></i></button>
                <ul class="user-menu">
                    <li><a href="profile.html">Profile</a></li>
                    <li><a href="#" id="logout-btn">Logout</a></li>
                </ul>
            </div>
        `;

        // Logout functionality
        document.getElementById("logout-btn").addEventListener("click", function (event) {
            event.preventDefault();
            localStorage.removeItem("user");
            localStorage.removeItem("token");
            updateNavbar(); // Reset navbar to show Login & Sign Up
            window.location.href = "index.html"; // Redirect to homepage after logout
        });
    } else {
        // If user is NOT logged in, show Login and Sign Up
        navIcons.innerHTML = `
            <a href="login.html" class="nav-icon">Login</a>
            <a href="signup.html" class="nav-icon">Sign Up</a>
        `;
    }
}


/////

document.addEventListener("DOMContentLoaded", function () {
    let menuToggle = document.querySelector(".menu-toggle");
    let mobileMenu = document.querySelector(".mobile-menu");

    if (menuToggle) {
        menuToggle.addEventListener("click", function () {
            mobileMenu.classList.toggle("active");
        });
    }
});


//cart js
document.addEventListener("DOMContentLoaded", function () {
    const cartIcon = document.getElementById("cart-icon");
    const sideCart = document.querySelector(".side-cart");
    const closeCartBtn = document.querySelector(".close-cart");
    const cartOverlay = document.querySelector(".cart-overlay");

    // Function to open cart
    function openCart() {
        sideCart.classList.add("open");
        cartOverlay.classList.add("show");
    }

    // Function to close cart
    function closeCart() {
        sideCart.classList.remove("open");
        cartOverlay.classList.remove("show");
    }

    // Event Listeners
    cartIcon.addEventListener("click", function (e) {
        e.preventDefault();
        openCart();
    });

    closeCartBtn.addEventListener("click", closeCart);
    cartOverlay.addEventListener("click", closeCart);
});


document.addEventListener("DOMContentLoaded", function () {
    const wishlistIcon = document.querySelector(".fa-heart"); // Heart icon in navbar
    const sideWishlist = document.querySelector(".side-wishlist");
    const closeWishlistBtn = document.querySelector(".close-wishlist");
    const wishlistOverlay = document.querySelector(".wishlist-overlay");

    // Function to open wishlist
    function openWishlist() {
        sideWishlist.classList.add("open");
        wishlistOverlay.classList.add("show");
    }

    // Function to close wishlist
    function closeWishlist() {
        sideWishlist.classList.remove("open");
        wishlistOverlay.classList.remove("show");
    }

    // Event Listeners
    wishlistIcon.addEventListener("click", function (e) {
        e.preventDefault();
        openWishlist();
    });

    closeWishlistBtn.addEventListener("click", closeWishlist);
    wishlistOverlay.addEventListener("click", closeWishlist);
});



    </script>
</body>

</html>
