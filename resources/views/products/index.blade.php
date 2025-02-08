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
<a href="/dashboard" class="fixed-dashboard-btn">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard
    </a>
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
                    @auth
                        <a href="/dashboard" class="btn btn-primary">لوحة التحكم</a>
                    @else
                        <a href="/login" class="btn btn-outline-primary me-2">تسجيل الدخول</a>
                        <a href="/register" class="btn btn-primary">إنشاء حساب</a>
                    @endauth
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
                                <span>{{ number_format($priceRange['min']) }} ر.س</span>
                                <span id="priceValue">{{ number_format($priceRange['max']) }} ر.س</span>
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
                            <option value="newest">الأحدث</option>
                            <option value="price-low">السعر: من الأقل للأعلى</option>
                            <option value="price-high">السعر: من الأعلى للأقل</option>
                        </select>
                    </div>
                </div>
                <div class="row g-4" id="productGrid">
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card">
                            <a href="{{ route('products.show', $product->slug) }}" class="product-image-wrapper">
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
                                <a href="{{ route('products.show', $product->slug) }}" class="product-title text-decoration-none">
                                    <h3>{{ $product->name }}</h3>
                                </a>
                                <div class="product-rating">
                                    <div class="stars" style="--rating: {{ $product['rating'] }}"></div>
                                    <span class="reviews">({{ $product['reviews'] }} تقييم)</span>
                                </div>
                                <p class="product-price">{{ number_format($product->price, 2) }} ر.س</p>
                                <div class="product-actions">
                                    <a href="{{ route('products.show', $product->slug) }}" class="order-product-btn">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        طلب المنتج
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
                <span id="cartTotal">0 ر.س</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="checkout-btn">
                <i class="fas fa-shopping-cart ml-2"></i>
                إتمام الشراء
            </a>
        </div>
    </div>

    <!-- Cart Overlay -->
    <div class="cart-overlay"></div>

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content glass-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title">تفاصيل المنتج</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div id="productCarousel" class="carousel slide product-carousel" data-bs-ride="carousel">
                                <div class="carousel-inner rounded-3">
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
                            <h3 id="modalProductName" class="product-title mb-3"></h3>
                            <p id="modalProductDescription" class="product-description mb-4"></p>
                            <div class="price-section mb-4">
                                <h4 id="modalProductPrice" class="product-price"></h4>
                            </div>
                            <div class="quantity-selector mb-4">
                                <label class="form-label">الكمية:</label>
                                <div class="input-group quantity-group">
                                    <button class="btn btn-outline-primary" type="button" id="decreaseQuantity">-</button>
                                    <input type="number" class="form-control text-center" id="productQuantity" value="1" min="1">
                                    <button class="btn btn-outline-primary" type="button" id="increaseQuantity">+</button>
                                </div>
                            </div>

                            <!-- Colors Section -->
                            <div class="colors-section mb-4" id="modalProductColors">
                                <label class="form-label">الألوان المتاحة:</label>
                                <div class="colors-grid">
                                    <!-- Colors will be added dynamically -->
                                </div>
                            </div>

                            <!-- Sizes Section -->
                            <div class="sizes-section mb-4" id="modalProductSizes">
                                <label class="form-label">المقاسات المتاحة:</label>
                                <div class="sizes-grid">
                                    <!-- Sizes will be added dynamically -->
                                </div>
                            </div>

                            <button class="btn add-to-cart-btn w-100" id="modalAddToCart">
                                <i class="fas fa-shopping-cart me-2"></i>
                                أضف للسلة
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Prompt Modal -->
    <div class="modal fade" id="loginPromptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تسجيل الدخول مطلوب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>يجب عليك تسجيل الدخول أو إنشاء حساب جديد لتتمكن من طلب المنتج</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">إنشاء حساب جديد</a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.appConfig = {
            routes: {
                products: {
                    filter: '{{ route("products.filter") }}',
                    details: '{{ route("products.details", ["product" => "__id__"]) }}'
                }
            }
        };

        let selectedColor = null;
        let selectedSize = null;

        // Add notification system
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} notification-toast position-fixed top-0 start-50 translate-middle-x mt-3`;
            notification.style.zIndex = '9999';
            notification.innerHTML = message;
            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Update cart display function
        function updateCartDisplay(data) {
            const cartItems = document.getElementById('cartItems');
            const cartTotal = document.getElementById('cartTotal');
            const cartCount = document.querySelector('.cart-count');

            // Animate count change
            const currentCount = parseInt(cartCount.textContent);
            const newCount = data.count;
            if (currentCount !== newCount) {
                cartCount.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    cartCount.textContent = newCount;
                    cartCount.style.transform = 'scale(1)';
                }, 200);
            }

            cartTotal.textContent = data.total + ' ر.س';

            // Clear current items with fade out effect
            cartItems.style.opacity = '0';
            setTimeout(() => {
                cartItems.innerHTML = '';

                if (data.items.length === 0) {
                    cartItems.innerHTML = `
                        <div class="cart-empty text-center p-4">
                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                            <p class="mb-3">السلة فارغة</p>
                            <a href="/products" class="btn btn-primary">تصفح المنتجات</a>
                        </div>
                    `;
                } else {
                    data.items.forEach(item => {
                        const itemElement = document.createElement('div');
                        itemElement.className = 'cart-item';
                        itemElement.dataset.itemId = item.id;
                        itemElement.innerHTML = `
                            <div class="cart-item-inner p-3 border-bottom">
                                <button class="remove-btn btn btn-link text-danger" onclick="confirmDelete(${item.id})">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="d-flex gap-3">
                                    <img src="${item.image}" alt="${item.name}" class="cart-item-image" style="width: 80px; height: 80px; object-fit: cover;">
                                    <div class="cart-item-details flex-grow-1">
                                        <h5 class="cart-item-title mb-2">${item.name}</h5>
                                        <div class="cart-item-price mb-2">${item.price} ر.س</div>
                                        <div class="quantity-controls d-flex align-items-center gap-2">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateCartQuantity(${item.id}, -1)">-</button>
                                            <input type="number" value="${item.quantity}" min="1"
                                                onchange="updateCartQuantity(${item.id}, 0, this.value)"
                                                class="form-control form-control-sm quantity-input" style="width: 60px;">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateCartQuantity(${item.id}, 1)">+</button>
                                        </div>
                                        <div class="cart-item-subtotal mt-2 text-primary">
                                            الإجمالي: ${item.subtotal} ر.س
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        cartItems.appendChild(itemElement);
                    });
                }
                // Fade in new items
                cartItems.style.opacity = '1';
            }, 300);
        }

        // Update cart quantity with animation
        function updateCartQuantity(itemId, change, newValue = null) {
            const quantityInput = document.querySelector(`[data-item-id="${itemId}"] .quantity-input`);
            const originalValue = parseInt(quantityInput.value);
            let quantity;

            if (newValue !== null) {
                quantity = parseInt(newValue);
            } else {
                quantity = originalValue + change;
            }

            if (quantity < 1) return;

            // Show loading state
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            itemElement.style.opacity = '0.5';

            fetch(`/cart/items/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCartItems();
                } else {
                    // Revert to original value if update failed
                    quantityInput.value = originalValue;
                    showNotification(data.message || 'Failed to update quantity', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert to original value
                quantityInput.value = originalValue;
                showNotification('حدث خطأ أثناء تحديث الكمية', 'error');
            })
            .finally(() => {
                itemElement.style.opacity = '1';
            });
        }

        // Remove cart item with animation
        function removeCartItem(itemId) {
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            itemElement.style.transform = 'translateX(100%)';
            itemElement.style.opacity = '0';

            fetch(`/cart/items/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    setTimeout(() => {
                        loadCartItems();
                    }, 300);
                    showNotification(data.message, 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء حذف المنتج', 'error');
                // Reset item state if delete failed
                itemElement.style.transform = 'none';
                itemElement.style.opacity = '1';
            });
        }

        function confirmDelete(itemId) {
            if (confirm('هل أنت متأكد من حذف هذا المنتج من السلة؟')) {
                removeCartItem(itemId);
            }
        }

        // Cart Functions
        function openCart() {
            document.getElementById('cartSidebar').classList.add('active');
            document.querySelector('.cart-overlay').classList.add('active');
            document.body.classList.add('cart-open');
        }

        function closeCart() {
            document.getElementById('cartSidebar').classList.remove('active');
            document.querySelector('.cart-overlay').classList.remove('active');
            document.body.classList.remove('cart-open');
        }

        function loadCartItems() {
            fetch('/cart/items')
                .then(response => response.json())
                .then(data => {
                    updateCartDisplay(data);
                })
                .catch(error => console.error('Error:', error));
        }

        // Quick add to cart from product grid
        function quickAddToCart(productId) {
            const addToCartBtn = document.querySelector(`.add-to-cart-btn[data-product-id="${productId}"]`);
            const originalBtnText = addToCartBtn.innerHTML;
            addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإضافة...';
            addToCartBtn.disabled = true;

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    loadCartItems();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء إضافة المنتج إلى السلة', 'error');
            })
            .finally(() => {
                addToCartBtn.innerHTML = originalBtnText;
                addToCartBtn.disabled = false;
            });
        }

        // Initialize cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            loadCartItems();

            // Setup event listeners
            document.getElementById('closeCart').addEventListener('click', closeCart);
            document.getElementById('cartToggle').addEventListener('click', openCart);
            document.querySelector('.cart-overlay')?.addEventListener('click', closeCart);

            // Setup quick add to cart buttons
            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    quickAddToCart(this.dataset.productId);
                });
            });
        });

        // Filter and Sort Functions
        let activeFilters = {
            categories: [],
            minPrice: {{ $priceRange['min'] }},
            maxPrice: {{ $priceRange['max'] }},
            sort: 'newest'
        };

        // Initialize price range slider with debounce
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        let priceUpdateTimeout;

        if (priceRange) {
            priceRange.addEventListener('input', function() {
                // Update display value immediately
                priceValue.textContent = Number(this.value).toLocaleString() + ' ر.س';

                // Update filter with debounce
                clearTimeout(priceUpdateTimeout);
                priceUpdateTimeout = setTimeout(() => {
                    activeFilters.maxPrice = Number(this.value);
                    applyFilters();
                }, 500); // Wait 500ms after user stops moving the slider
            });

            // Add touchend/mouseup event to ensure filter is applied when user releases slider
            priceRange.addEventListener('change', function() {
                clearTimeout(priceUpdateTimeout);
                activeFilters.maxPrice = Number(this.value);
                applyFilters();
            });
        }

        // Category filter handlers
        document.querySelectorAll('.form-check-input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const categoryId = Number(this.value);
                if (this.checked) {
                    if (!activeFilters.categories.includes(categoryId)) {
                        activeFilters.categories.push(categoryId);
                    }
                } else {
                    activeFilters.categories = activeFilters.categories.filter(id => id !== categoryId);
                }
                applyFilters();
            });
        });

        // Sort handler
        document.getElementById('sortSelect').addEventListener('change', function() {
            activeFilters.sort = this.value;
            applyFilters();
        });

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function applyFilters() {
            // Show loading state
            const productGrid = document.getElementById('productGrid');
            productGrid.style.opacity = '0.5';

            // Create a copy of activeFilters to ensure clean data
            const filterData = {
                categories: activeFilters.categories,
                minPrice: Number(activeFilters.minPrice),
                maxPrice: Number(activeFilters.maxPrice),
                sort: activeFilters.sort
            };

            fetch('{{ route("products.filter") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(filterData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.products) {
                    updateProductGrid(data.products);
                    if (data.pagination) {
                        updatePagination(data.pagination);
                    }
                } else {
                    throw new Error('Invalid response format');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء تحديث المنتجات', 'error');
            })
            .finally(() => {
                productGrid.style.opacity = '1';
            });
        }

        function updateProductGrid(products) {
            const productGrid = document.getElementById('productGrid');
            productGrid.innerHTML = '';

            if (products.length === 0) {
                productGrid.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                        <h3>لا توجد منتجات</h3>
                        <p class="text-muted">لم يتم العثور على منتجات تطابق معايير البحث</p>
                    </div>
                `;
                return;
            }

            products.forEach(product => {
                const productElement = document.createElement('div');
                productElement.className = 'col-md-6 col-lg-4';
                productElement.innerHTML = `
                    <div class="product-card">
                        <a href="/products/${product.slug}" class="product-image-wrapper">
                            <img src="${product.image_url}" alt="${product.name}" class="product-image">
                        </a>
                        <div class="product-details">
                            <div class="product-category">${product.category}</div>
                            <a href="/products/${product.slug}" class="product-title text-decoration-none">
                                <h3>${product.name}</h3>
                            </a>
                            <div class="product-rating">
                                <div class="stars" style="--rating: ${product.rating}"></div>
                                <span class="reviews">(${product.reviews} تقييم)</span>
                            </div>
                            <p class="product-price">${product.price} ر.س</p>
                            <div class="product-actions">
                                <a href="/products/${product.slug}" class="order-product-btn">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    طلب المنتج
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                productGrid.appendChild(productElement);
            });
        }

        function updatePagination(pagination) {
            // Add pagination update logic if needed
        }

        function showLoginPrompt(loginUrl) {
            const modal = new bootstrap.Modal(document.getElementById('loginPromptModal'));
            modal.show();
        }
    </script>

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

        /* Cart Styles */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            max-width: 400px;
            height: 100vh;
            background: #fff;
            box-shadow: -2px 0 5px rgba(0,0,0,0.1);
            z-index: 1050;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .cart-sidebar.active {
            right: 0;
        }

        .cart-header {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            flex-shrink: 0;
        }

        .cart-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            transition: opacity 0.3s ease;
        }

        .cart-item {
            background: #fff;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: transform 0.3s ease, opacity 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .cart-item:last-child {
            margin-bottom: 0;
        }

        .cart-item-inner {
            position: relative;
            padding: 1rem;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .cart-item-details {
            padding-right: 1rem;
        }

        .cart-item-title {
            font-size: 1rem;
            margin: 0;
            color: #333;
        }

        .cart-item-price {
            color: #666;
            font-weight: 500;
        }

        .cart-item-subtotal {
            font-weight: 600;
            color: #007bff;
        }

        .remove-btn {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            padding: 0.25rem;
            line-height: 1;
            border: none;
            background: none;
            color: #dc3545;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .remove-btn:hover {
            opacity: 1;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.5rem 0;
        }

        .quantity-controls button {
            width: 28px;
            height: 28px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            border-radius: 4px;
        }

        .quantity-input {
            width: 50px !important;
            text-align: center;
            padding: 0.25rem;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .cart-footer {
            padding: 1rem;
            border-top: 1px solid #eee;
            background: #fff;
            flex-shrink: 0;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background: #007bff;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            font-weight: 600;
        }

        .checkout-btn:hover {
            background: #0056b3;
            color: white;
            transform: translateY(-1px);
        }

        .cart-empty {
            text-align: center;
            padding: 2rem;
        }

        .cart-empty i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 1rem;
        }

        .cart-empty p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        /* Custom Scrollbar for Cart Items */
        .cart-items::-webkit-scrollbar {
            width: 6px;
        }

        .cart-items::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .cart-items::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        .cart-items::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        /* Ensure the body doesn't scroll when cart is open */
        body.cart-open {
            overflow: hidden;
        }

        .order-product-btn {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            background: #6c5ce7;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            margin-top: 1rem;
        }

        .order-product-btn:hover {
            background: #5849c2;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(108, 92, 231, 0.2);
        }

        .order-product-btn i {
            margin-left: 0.5rem;
        }

        .product-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .product-details {
            padding: 1rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-category {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .product-title h3 {
            font-size: 1.1rem;
            margin: 0 0 0.5rem 0;
            font-weight: 600;
            color: #333;
        }

        .product-price {
            font-size: 1.25rem;
            font-weight: bold;
            color: #6c5ce7;
            margin: 0.5rem 0;
        }

        .product-rating {
            margin-bottom: 0.5rem;
        }

        .reviews {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .filter-sidebar {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 1.5rem;
            position: sticky;
            top: 100px;
        }

        .filter-container h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .filter-section {
            margin-bottom: 2rem;
        }

        .filter-section h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #555;
        }

        .form-check {
            margin-bottom: 0.5rem;
        }

        .form-check-label {
            color: #666;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .form-check-input:checked + .form-check-label {
            color: #6c5ce7;
            font-weight: 500;
        }

        .price-range {
            padding: 0.5rem 0;
        }

        .price-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
            color: #666;
            font-size: 0.9rem;
        }

        .form-range::-webkit-slider-thumb {
            background: #6c5ce7;
        }

        .form-range::-webkit-slider-runnable-track {
            background: #e9ecef;
        }

        .glass-select {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(108, 92, 231, 0.2);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            color: #333;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .glass-select:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.1);
        }

        @media (max-width: 991.98px) {
            .filter-sidebar {
                position: static;
                margin-bottom: 2rem;
            }
        }


    .fixed-dashboard-btn {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: #6c5ce7;
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        .fixed-dashboard-btn:hover {
            background: #5849c2;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(108, 92, 231, 0.4);
        }

        .fixed-dashboard-btn i {
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .fixed-dashboard-btn {
                bottom: 20px;
                right: 20px;
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }

        /* Modal Styles */
        .glass-modal {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
        }

        .modal-header {
            padding: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .product-carousel {
            background: #f8f9fa;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .product-carousel .carousel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .carousel-control-prev,
        .carousel-control-next {
            background: rgba(0,0,0,0.3);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 1rem;
        }

        .product-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #333;
        }

        .product-description {
            color: #666;
            line-height: 1.6;
        }

        .product-price {
            font-size: 1.5rem;
            color: #6c5ce7;
            font-weight: 600;
        }

        .quantity-group {
            max-width: 200px;
        }

        .quantity-group .btn {
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .quantity-group input {
            height: 40px;
            text-align: center;
            border-right: 1px solid #dee2e6;
            border-left: 1px solid #dee2e6;
        }

        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 0.75rem;
        }

        .color-item {
            padding: 0.75rem 1.25rem;
            border-radius: 25px;
            background: #f8f9fa;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-item.selected {
            background: #6c5ce7;
            color: white;
            border-color: #5849c2;
            transform: translateY(-2px);
        }

        .color-item:not(.available) {
            opacity: 0.5;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .size-item {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #f8f9fa;
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .size-item.selected {
            background: #6c5ce7;
            color: white;
            border-color: #5849c2;
            transform: translateY(-2px);
        }

        .size-item:not(.available) {
            opacity: 0.5;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        #modalAddToCart {
            background: #6c5ce7;
            color: white;
            padding: 1rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        #modalAddToCart:hover {
            background: #5849c2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.2);
        }

        @media (max-width: 768px) {
            .product-carousel .carousel-item img {
                height: 300px;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .glass-modal {
                border-radius: 12px;
            }
        }
    </style>

    <script>
        function updateProductModal(product) {
            $('#modalProductName').text(product.name);
            $('#modalProductDescription').text(product.description);
            $('#modalProductPrice').text(product.price + ' ر.س');

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
