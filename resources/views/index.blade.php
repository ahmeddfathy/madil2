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
    <title>متجر بر الليث | الرئيسية</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/font-awesome.min.css') }}" type="text/css">
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

            <a href="#" class="search-switch"><img src="{{ asset('assets/kids-clothes/img/icon/search.png') }}" alt=""></a>
            <a href="#"><img src="{{ asset('assets/kids-clothes/img/icon/heart.png') }}" alt=""></a>
            <a href="#"><img src="{{ asset('assets/kids-clothes/img/icon/cart.png') }}" alt=""> <span>0</span></a>
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
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('services') }}">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                        </li>
                        <li class="nav-item">
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

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="{{ asset('assets/kids-clothes/img/hero/hero-1.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Winter Collection</h6>
                                <h2>Fall - Winter Collections 2030</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                commitment to exceptional quality.</p>
                                <a href="shop.html" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="{{ asset('assets/kids-clothes/img/hero/hero-2.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2030</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                commitment to exceptional quality.</p>
                                <a href="#" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-4">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="{{ asset('assets/kids-clothes/img/banner/banner-1.jpg') }}" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Clothing Collections 2025</h2>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner__item banner__item--middle">
                        <div class="banner__item__pic">
                            <img src="{{ asset('assets/kids-clothes/img/banner/banner-2.jpg') }}" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Accessories</h2>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="banner__item banner__item--last">
                        <div class="banner__item__pic">
                            <img src="{{ asset('assets/kids-clothes/img/banner/banner-3.jpg') }}" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Clothes Spring 2025</h2>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Categories Section Begin -->
    <section class="categories spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>Clothings Hot <br /> <span>Shoe Collection</span> <br /> Accessories</h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories__hot__deal">
                        <img src="{{ asset('assets/kids-clothes/img/product-sale.png') }}" alt="">
                        <div class="hot__deal__sticker">
                            <span>Sale Of</span>
                            <h5>$29.99</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="categories__deal__countdown">
                        <span>Deal Of The Week</span>
                        <h2>Multi-pocket Chest Bag Black</h2>
                        <div class="categories__deal__countdown__timer" id="countdown">
                            <div class="cd-item">
                                <span>3</span>
                                <p>Days</p>
                            </div>
                            <div class="cd-item">
                                <span>1</span>
                                <p>Hours</p>
                            </div>
                            <div class="cd-item">
                                <span>50</span>
                                <p>Minutes</p>
                            </div>
                            <div class="cd-item">
                                <span>18</span>
                                <p>Seconds</p>
                            </div>
                        </div>
                        <a href="shop.html" class="primary-btn">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Instagram Section Begin -->
    <section class="instagram spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="instagram__pic">
                        <div class="instagram__pic__item set-bg" data-setbg="{{ asset('assets/kids-clothes/img/instagram/instagram-1.jpg') }}"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="{{ asset('assets/kids-clothes/img/instagram/instagram-2.jpg') }}"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="{{ asset('assets/kids-clothes/img/instagram/instagram-3.jpg') }}"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="{{ asset('assets/kids-clothes/img/instagram/instagram-4.jpg') }}"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="{{ asset('assets/kids-clothes/img/instagram/instagram-5.jpg') }}"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="{{ asset('assets/kids-clothes/img/instagram/instagram-6.jpg') }}"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="instagram__text">
                        <h2>Instagram</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                        <h3>#Kids_Fashion</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->

<br>


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
        <div class="cart-overlay"></div>


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
                            <a href="#"><img src="{{ asset('assets/kids-clothes/img/logo.png') }}" width="100" height="150" alt=""></a>
                        </div>
                        <p>The customer is at the heart of our unique business model, which includes design.</p>
                        <a href="#"><img src="{{ asset('assets/kids-clothes/img/payment.png') }}" alt=""></a>
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

document.addEventListener("DOMContentLoaded", function () {
    updateNavbar();
});

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


////

/* document.addEventListener("DOMContentLoaded", function () {
    const user = JSON.parse(localStorage.getItem("user"));

    if (!user) {
        window.location.href = "login.html"; // Redirect to login if not logged in
        return;
    }

    document.getElementById("name").value = user.name;
    document.getElementById("email").value = user.email;
    document.getElementById("address").value = user.address || ""; // Show empty field if no address

    // Logout Button Click
    const logoutBtn = document.getElementById("logout-btn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function (event) {
            event.preventDefault();
            localStorage.removeItem("user");
            localStorage.removeItem("token");
            window.location.href = "index.html"; // Redirect to homepage after logout
        });
    }
}); */

////

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
