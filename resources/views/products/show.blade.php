<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - Madil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products-show.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg glass-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">Madil</a>
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

    <!-- Add this after navbar -->
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
            <a href="{{ route('checkout.index') }}" class="checkout-btn">
                <i class="fas fa-shopping-cart ml-2"></i>
                إتمام الشراء
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="/products">المنتجات</a></li>
                <li class="breadcrumb-item"><a href="/products?category={{ $product->category->id }}">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-md-6">
                <div class="product-gallery card">
                    <div class="card-body">
                        @if($product->images->count() > 0)
                            <div class="main-image-wrapper mb-3">
                                <img src="{{ Storage::url($product->primary_image->image_path) }}"
                                    alt="{{ $product->name }}"
                                    class="main-product-image"
                                    id="mainImage">
                            </div>
                            @if($product->images->count() > 1)
                                <div class="image-thumbnails">
                                    @foreach($product->images as $image)
                                        <div class="thumbnail-wrapper {{ $image->is_primary ? 'active' : '' }}"
                                            onclick="updateMainImage('{{ Storage::url($image->image_path) }}', this)">
                                            <img src="{{ Storage::url($image->image_path) }}"
                                                alt="Product thumbnail"
                                                class="thumbnail-image">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="no-image-placeholder">
                                <i class="fas fa-image"></i>
                                <p>لا توجد صور متاحة</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $product->name }}</h1>

                    <div class="category-badge mb-3">
                        <i class="fas fa-tag me-1"></i>
                        {{ $product->category->name }}
                    </div>

                    <div class="product-price mb-4">
                        <span class="currency">ج.م</span>
                        <span class="amount">{{ number_format($product->price, 2) }}</span>
                    </div>

                    <div class="stock-info mb-4">
                        <span class="stock-badge {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                            <i class="fas {{ $product->stock > 0 ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                            {{ $product->stock > 0 ? 'متوفر' : 'غير متوفر' }}
                        </span>
                        @if($product->stock > 0)
                            <span class="stock-count">({{ $product->stock }} قطعة متوفرة)</span>
                        @endif
                    </div>

                    <div class="product-description mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-info-circle me-2"></i>
                            وصف المنتج
                        </h5>
                        <p>{{ $product->description }}</p>
                    </div>

                    <!-- Colors Section -->
                    @if($product->colors && $product->colors->isNotEmpty())
                        <div class="colors-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-palette me-2"></i>
                                الألوان المتاحة
                            </h5>
                            <div class="colors-grid">
                                @foreach($product->colors as $color)
                                    <div class="color-item {{ $color->is_available ? 'available' : 'unavailable' }}"
                                        data-color="{{ $color->color }}"
                                        onclick="selectColor(this)">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="color-preview" style="background-color: {{ $color->color }}"></span>
                                            <span class="color-name">{{ $color->color }}</span>
                                        </div>
                                        <span class="color-status">
                                            @if($color->is_available)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Sizes Section -->
                    @if($product->sizes && $product->sizes->isNotEmpty())
                        <div class="sizes-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-ruler me-2"></i>
                                المقاسات المتاحة
                            </h5>
                            <div class="sizes-grid">
                                @foreach($product->sizes as $size)
                                    <div class="size-item {{ $size->is_available ? 'available' : 'unavailable' }}"
                                        data-size="{{ $size->size }}"
                                        onclick="selectSize(this)">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-ruler"></i>
                                            <span class="size-name">{{ $size->size }}</span>
                                        </div>
                                        <span class="size-status">
                                            @if($size->is_available)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quantity Selector -->
                    <div class="quantity-selector mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-shopping-basket me-2"></i>
                            الكمية
                        </h5>
                        <div class="input-group" style="width: 150px;">
                            <button class="btn btn-outline-primary" type="button" onclick="updatePageQuantity(-1)">-</button>
                            <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button class="btn btn-outline-primary" type="button" onclick="updatePageQuantity(1)">+</button>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button class="btn btn-primary btn-lg w-100 mb-4" onclick="addToCart()">
                        <i class="fas fa-shopping-cart me-2"></i>
                        أضف إلى السلة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5 py-4">
        <div class="container">
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
    </footer>

    <!-- إضافة Modal لحجز الموعد -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حجز موعد للمقاسات</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm" action="{{ route('appointments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_type" value="new_abaya">
                        <input type="hidden" name="cart_item_id" id="cart_item_id">

                        <div class="mb-3">
                            <label for="appointment_date" class="form-label">تاريخ الموعد</label>
                            <input type="date" class="form-control" id="appointment_date" name="appointment_date"
                                   min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="appointment_time" class="form-label">وقت الموعد</label>
                            <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">الموقع</label>
                            <select class="form-control" id="location" name="location" required onchange="toggleAddress()">
                                <option value="store">في المحل</option>
                                <option value="client_location">موقع العميل</option>
                            </select>
                        </div>

                        <div class="mb-3" id="addressField" style="display: none;">
                            <label for="address" class="form-label">العنوان</label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                   value="{{ Auth::user()->phone ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">تأكيد الحجز</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let selectedColor = null;
        let selectedSize = null;

        function updateMainImage(src, thumbnail) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail-wrapper').forEach(thumb => {
                thumb.classList.remove('active');
            });
            if (thumbnail) {
                thumbnail.classList.add('active');
            }
        }

        function selectColor(element) {
            if (!element.classList.contains('available')) {
                showAlert('هذا اللون غير متوفر حالياً');
                return;
            }

            document.querySelectorAll('.color-item').forEach(item => {
                item.classList.remove('selected');
            });
            element.classList.add('selected');
            selectedColor = element.dataset.color;
        }

        function selectSize(element) {
            if (!element.classList.contains('available')) {
                showAlert('هذا المقاس غير متوفر حالياً');
                return;
            }

            document.querySelectorAll('.size-item').forEach(item => {
                item.classList.remove('selected');
            });
            element.classList.add('selected');
            selectedSize = element.dataset.size;
        }

        function updatePageQuantity(change) {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value) || 1;
            const maxStock = parseInt(input.getAttribute('max'));

            let newValue = currentValue + change;
            newValue = Math.max(1, Math.min(newValue, maxStock));

            input.value = newValue;
        }

        function showAppointmentModal(cartItemId) {
            document.getElementById('cart_item_id').value = cartItemId;
            const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
            modal.show();
        }

        function toggleAddress() {
            const location = document.getElementById('location').value;
            const addressField = document.getElementById('addressField');
            addressField.style.display = location === 'client_location' ? 'block' : 'none';
        }

        function addToCart() {
            const quantity = parseInt(document.getElementById('quantity').value);
            let validationPassed = true;
            let errorMessage = '';

            // Validate quantity
            if (isNaN(quantity) || quantity < 1) {
                validationPassed = false;
                errorMessage = 'الرجاء اختيار كمية صحيحة';
            }

            // Validate color selection if colors exist
            const hasColors = document.querySelector('.colors-section') !== null;
            if (hasColors && !selectedColor) {
                validationPassed = false;
                errorMessage = 'الرجاء اختيار اللون';
            }

            // Validate size selection if sizes exist
            const hasSizes = document.querySelector('.sizes-section') !== null;
            if (hasSizes && !selectedSize) {
                validationPassed = false;
                errorMessage = 'الرجاء اختيار المقاس';
            }

            // Show error message and return if validation fails
            if (!validationPassed) {
                showAlert(errorMessage);
                return;
            }

            // Proceed with adding to cart if validation passes
            const data = {
                product_id: {{ $product->id }},
                quantity: quantity,
                color: selectedColor,
                size: selectedSize,
                _token: document.querySelector('meta[name="csrf-token"]').content
            };

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCartItems();
                    showAlert(data.message);

                    // عرض نافذة حجز الموعد
                    if (data.show_appointment) {
                        showAppointmentModal(data.cart_item_id);
                    }
                } else {
                    showAlert(data.message || 'حدث خطأ أثناء إضافة المنتج إلى السلة');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('حدث خطأ أثناء إضافة المنتج إلى السلة');
            });
        }

        // Cart Functions
        function openCart() {
            document.getElementById('cartSidebar').classList.add('active');
        }

        function closeCart() {
            document.getElementById('cartSidebar').classList.remove('active');
        }

        function loadCartItems() {
            fetch('/cart/items')
                .then(response => response.json())
                .then(data => {
                    updateCartDisplay(data);
                })
                .catch(error => console.error('Error:', error));
        }

        function updateCartDisplay(data) {
            const cartItems = document.getElementById('cartItems');
            const cartTotal = document.getElementById('cartTotal');
            const cartCount = document.querySelector('.cart-count');

            cartCount.textContent = data.count;
            cartTotal.textContent = data.total + ' ج.م';

            cartItems.innerHTML = '';

            if (data.items.length === 0) {
                cartItems.innerHTML = `
                    <div class="cart-empty">
                        <i class="fas fa-shopping-cart"></i>
                        <p>السلة فارغة</p>
                        <a href="/products" class="btn btn-primary mt-3">تصفح المنتجات</a>
                    </div>
                `;
                return;
            }

            data.items.forEach(item => {
                cartItems.innerHTML += `
                    <div class="cart-item" data-item-id="${item.id}">
                        <button class="remove-btn" onclick="confirmDelete(${item.id})">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="d-flex gap-3">
                            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                            <div class="cart-item-details">
                                <h5 class="cart-item-title">${item.name}</h5>
                                <div class="cart-item-price">${item.price} ج.م</div>
                                <div class="quantity-controls">
                                    <button onclick="updateCartQuantity(${item.id}, -1)">-</button>
                                    <input type="number" value="${item.quantity}"
                                        min="1"
                                        onchange="updateCartQuantity(${item.id}, 0, this.value)"
                                        class="quantity-input">
                                    <button onclick="updateCartQuantity(${item.id}, 1)">+</button>
                                </div>
                                <div class="cart-item-subtotal">
                                    الإجمالي: ${item.subtotal} ج.م
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        function updateCartQuantity(itemId, change, newValue = null) {
            let quantity;
            if (newValue !== null) {
                quantity = parseInt(newValue);
            } else {
                const input = document.querySelector(`[data-item-id="${itemId}"] .quantity-input`);
                quantity = parseInt(input.value) + change;
            }

            if (quantity < 1) return;

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
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('حدث خطأ أثناء تحديث الكمية');
            });
        }

        function confirmDelete(itemId) {
            if (confirm('هل أنت متأكد من حذف هذا المنتج من السلة؟')) {
                removeCartItem(itemId);
            }
        }

        function removeCartItem(itemId) {
            fetch(`/cart/items/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
                    itemElement.style.animation = 'slideOut 0.3s ease-out forwards';
                    setTimeout(() => {
                        loadCartItems();
                    }, 300);
                    showAlert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('حدث خطأ أثناء حذف المنتج');
            });
        }

        // Initialize cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            loadCartItems();

            // Setup event listeners
            document.getElementById('closeCart').addEventListener('click', closeCart);
            document.getElementById('cartToggle').addEventListener('click', openCart);
        });

        // Replace the showAlert function with a simpler alert
        function showAlert(message) {
            alert(message);
        }
    </script>


</body>
</html>
