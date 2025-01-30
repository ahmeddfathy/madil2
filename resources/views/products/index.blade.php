<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>المنتجات - Madil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg glass-navbar sticky-top">
      <div class="container">
            <a class="navbar-brand" href="/">
           Madil
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                        <a class="nav-link" href="/">الرئيسية</a>
                  </li>
                  <li class="nav-item">
                        <a class="nav-link" href="/about">من نحن</a>
                  </li>
                  <li class="nav-item">
                        <a class="nav-link active" href="/products">المنتجات</a>
                  </li>
                  <li class="nav-item">
                        <a class="nav-link" href="/profile">حسابي</a>
                  </li>
              </ul>
              <div class="nav-buttons">
                    <button class="btn btn-outline-primary position-relative me-2" id="cartToggle">
                      <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                            0
                      </span>
                    </button>
                    <a href="/login" class="btn btn-outline-primary me-2">تسجيل الدخول</a>
                    <a href="/register" class="btn btn-primary">إنشاء حساب</a>
              </div>
          </div>
      </div>
    </nav>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-shopping-cart me-2"></i>
                <strong class="me-auto">تحديث السلة</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                تم إضافة المنتج إلى السلة بنجاح!
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-3 filter-sidebar">
                <div class="filter-container">
                    <h3>الفلاتر</h3>
                    <div class="filter-section">
                        <h4>الفئات</h4>
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="category_{{ $category->id }}">
                            <label class="form-check-label" for="category_{{ $category->id }}">
                                {{ $category->name }} ({{ $category->products_count }})
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="filter-section">
                        <h4>نطاق السعر</h4>
                        <div class="price-range">
                            <input type="range" class="form-range" id="priceRange"
                                min="{{ $priceRange['min'] }}"
                                max="{{ $priceRange['max'] }}"
                                value="{{ $priceRange['max'] }}">
                            <div class="price-labels">
                                <span>{{ number_format($priceRange['min']) }} ج.م</span>
                                <span id="priceValue">{{ number_format($priceRange['max']) }} ج.م</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="section-header mb-4">
                    <h2>جميع المنتجات</h2>
                    <div class="sort-options">
                        <select class="form-select glass-select" id="sortSelect">
                            <option value="featured">الأكثر تميزاً</option>
                            <option value="price-low">السعر: من الأقل للأعلى</option>
                            <option value="price-high">السعر: من الأعلى للأقل</option>
                            <option value="newest">الأحدث</option>
                        </select>
                    </div>
                </div>
                <div class="row g-4" id="productGrid">
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card">
                            <a href="{{ route('products.show', $product->id) }}" class="product-image-wrapper">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                         alt="{{ $product->name }}"
                                         class="product-image">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}"
                                         alt="{{ $product->name }}"
                                         class="product-image">
                                @endif
                            </a>
                            <div class="product-details">
                                <div class="product-category">{{ $product->category->name }}</div>
                                <a href="{{ route('products.show', $product->id) }}" class="product-title text-decoration-none">
                                    <h3>{{ $product->name }}</h3>
                                </a>
                                <div class="product-rating">
                                    <div class="stars" style="--rating: {{ $product['rating'] }}"></div>
                                    <span class="reviews">({{ $product['reviews'] }} تقييم)</span>
                                </div>
                                <p class="product-price">{{ number_format($product->price, 2) }} ج.م</p>
                                <div class="product-actions">
                                    <button type="button" class="add-to-cart-btn" data-product-id="{{ $product->id }}">
                                        <i class="fas fa-shopping-cart me-2"></i>أضف للسلة
                                    </button>
                                    <a href="{{ route('products.show', $product->id) }}" class="view-details-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Shopping Cart Sidebar -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3>سلة التسوق</h3>
            <button class="close-cart" id="closeCart">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items" id="cartItems">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>الإجمالي:</span>
                <span id="cartTotal">0 ج.م</span>
            </div>
            <button class="btn checkout-btn">إتمام الشراء</button>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تفاصيل المنتج</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <!-- Carousel items will be dynamically added -->
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 id="modalProductName"></h3>
                            <p id="modalProductDescription" class="my-3"></p>
                            <div class="price-section">
                                <h4 id="modalProductPrice"></h4>
                            </div>
                            <div class="quantity-selector my-3">
                                <label>الكمية:</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" id="decreaseQuantity">-</button>
                                    <input type="number" class="form-control text-center" id="productQuantity" value="1" min="1">
                                    <button class="btn btn-outline-secondary" type="button" id="increaseQuantity">+</button>
                                </div>
                            </div>

                            <!-- Colors Section -->
                            <div class="colors-section my-3" id="modalProductColors">
                                <label>الألوان المتاحة:</label>
                                <div class="colors-grid">
                                    <!-- Colors will be added dynamically -->
                                </div>
                            </div>

                            <!-- Sizes Section -->
                            <div class="sizes-section my-3" id="modalProductSizes">
                                <label>المقاسات المتاحة:</label>
                                <div class="sizes-grid">
                                    <!-- Sizes will be added dynamically -->
                                </div>
                            </div>

                            <button class="btn add-to-cart-btn w-100" id="modalAddToCart">أضف للسلة</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="glass-footer mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>عن Madil</h5>
                    <p>متجرك المفضل للمنتجات المميزة بأفضل الأسعار وأعلى جودة.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="/privacy">سياسة الخصوصية</a></li>
                        <li><a href="/terms">الشروط والأحكام</a></li>
                        <li><a href="/shipping">معلومات الشحن</a></li>
                        <li><a href="/faq">الأسئلة الشائعة</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>تواصل معنا</h5>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0">&copy; {{ date('Y') }} Madil. جميع الحقوق محفوظة</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        window.appConfig = {
            routes: {
                products: {
                    filter: '{{ route("products.filter") }}',
                    details: '{{ route("products.details", ["product" => "__id__"]) }}'
                }
            }
        };
    </script>
    <script src="{{ asset('assets/js/products.js') }}"></script>

    <style>
        .colors-grid,
        .sizes-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .color-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-item.selected {
            background: #007bff;
            color: white;
            border-color: #0056b3;
        }

        .color-item:not(.available) {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .size-item {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .size-item.selected {
            background: #007bff;
            color: white;
            border-color: #0056b3;
        }

        .size-item:not(.available) {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .product-image-wrapper {
            position: relative;
            padding-top: 100%;
            overflow: hidden;
            display: block;
            border-radius: 8px 8px 0 0;
            background: #f8f9fa;
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-image-wrapper:hover .product-image {
            transform: scale(1.05);
        }

        .product-title {
            color: var(--bs-dark);
            transition: color 0.3s ease;
        }

        .product-title:hover {
            color: var(--bs-primary);
        }

        .view-details-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--bs-light);
            color: var(--bs-primary);
            border: 1px solid var(--bs-primary);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .view-details-btn:hover {
            background: var(--bs-primary);
            color: white;
        }
    </style>

    <script>
        function updateProductModal(product) {
            $('#modalProductName').text(product.name);
            $('#modalProductDescription').text(product.description);
            $('#modalProductPrice').text(product.price + ' ج.م');

            // Update colors
            const colorsContainer = $('#modalProductColors .colors-grid');
            colorsContainer.empty();
            if (product.colors && product.colors.length > 0) {
                product.colors.forEach(color => {
                    const colorItem = $(`<div class="color-item ${color.is_available ? 'available' : ''}" data-color="${color.name}">
                        <span>${color.name}</span>
                    </div>`);
                    colorsContainer.append(colorItem);
                });
                $('#modalProductColors').show();
            } else {
                $('#modalProductColors').hide();
            }

            // Update sizes
            const sizesContainer = $('#modalProductSizes .sizes-grid');
            sizesContainer.empty();
            if (product.sizes && product.sizes.length > 0) {
                product.sizes.forEach(size => {
                    const sizeItem = $(`<div class="size-item ${size.is_available ? 'available' : ''}" data-size="${size.name}">
                        <span>${size.name}</span>
                    </div>`);
                    sizesContainer.append(sizeItem);
                });
                $('#modalProductSizes').show();
            } else {
                $('#modalProductSizes').hide();
            }

            // Update carousel
            const carouselInner = $('#productCarousel .carousel-inner');
            carouselInner.empty();
            product.images.forEach((image, index) => {
                carouselInner.append(`
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img src="${image}" class="d-block w-100" alt="${product.name}">
                    </div>
                `);
            });
        }

        // Handle color selection
        $(document).on('click', '.color-item.available', function() {
            $('.color-item').removeClass('selected');
            $(this).addClass('selected');
        });

        // Handle size selection
        $(document).on('click', '.size-item.available', function() {
            $('.size-item').removeClass('selected');
            $(this).addClass('selected');
        });
    </script>
</body>
</html>
