<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Checkout') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/checkout.css') }}">

</head>
<body class="checkout-container">
    <!-- Header -->
    <header class="checkout-header">
        <div class="container">
            <div class="header-content">
                <h2>{{ __('إتمام الطلب') }}</h2>
                <a href="{{ route('cart.index') }}" class="back-to-cart-btn">
                    العودة إلى السلة
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="checkout-content">
        <div class="container">
            <div class="checkout-wrapper">
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf

                    @if ($errors->any())
                    <div class="error-container">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="error-message">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="checkout-grid">
                        <!-- Order Summary -->
                        <div class="order-summary">
                            <h3>ملخص الطلب</h3>
                            <div class="order-items">
                                @if(Auth::check() && isset($cart))
                                    @foreach($cart->items as $item)
                                    <div class="order-item">
                                        <div class="product-info">
                                            <div class="product-image">
                                                <x-product-image :product="$item->product" size="16" />
                                            </div>
                                            <div class="product-details">
                                                <h4>{{ $item->product->name }}</h4>
                                                <p>الكمية: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <p class="product-price">
                                            {{ number_format($item->subtotal / 100, 2) }} ريال
                                        </p>
                                    </div>
                                    @endforeach
                                @else
                                    @foreach($products as $product)
                                    <div class="order-item">
                                        <div class="product-info">
                                            <div class="product-image">
                                                @if($product->primary_image)
                                                    <img src="{{ Storage::url($product->primary_image->image_path) }}"
                                                        alt="{{ $product->name }}">
                                                @else
                                                    <div class="placeholder-image">
                                                        <svg viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-details">
                                                <h4>{{ $product->name }}</h4>
                                                <p>الكمية: {{ $sessionCart[$product->id] }}</p>
                                            </div>
                                        </div>
                                        <p class="product-price">
                                            {{ number_format($product->price * $sessionCart[$product->id] / 100, 2) }} ريال
                                        </p>
                                    </div>
                                    @endforeach
                                @endif

                                <div class="total-amount">
                                    <span>الإجمالي:</span>
                                    <span>
                                        @if(Auth::check() && isset($cart))
                                            {{ number_format($cart->total_amount / 100, 2) }} ريال
                                        @else
                                            {{ number_format($total / 100, 2) }} ريال
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div class="shipping-info">
                            <h3>معلومات الشحن</h3>
                            <div class="form-groups">
                                <div class="form-group">
                                    <label for="shipping_address" class="form-label">
                                        عنوان الشحن
                                    </label>
                                    <textarea name="shipping_address" id="shipping_address" rows="4"
                                        class="form-input"
                                        placeholder="أدخل عنوان الشحن الكامل"
                                        required>{{ old('shipping_address', Auth::user()->address ?? '') }}</textarea>
                                    @error('shipping_address')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="form-label">
                                        رقم الهاتف
                                    </label>
                                    <input type="tel" name="phone" id="phone"
                                        value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                        class="form-input"
                                        placeholder="05xxxxxxxx"
                                        required>
                                    @error('phone')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Method -->
                                <div class="form-group">
                                    <label class="form-label">
                                        طريقة الدفع
                                    </label>
                                    <div class="payment-method">
                                        <label class="radio-group">
                                            <input type="radio" name="payment_method" value="cash"
                                                {{ old('payment_method') == 'cash' ? 'checked' : '' }} required>
                                            <span>الدفع عند الاستلام</span>
                                        </label>
                                        <label class="radio-group">
                                            <input type="radio" name="payment_method" value="card"
                                                {{ old('payment_method') == 'card' ? 'checked' : '' }} required>
                                            <span>بطاقة ائتمان/مدى</span>
                                        </label>
                                    </div>
                                    @error('payment_method')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="notes" class="form-label">
                                        ملاحظات الطلب (اختياري)
                                    </label>
                                    <textarea name="notes" id="notes" rows="4"
                                        class="form-input"
                                        placeholder="أي ملاحظات إضافية للطلب">{{ old('notes') }}</textarea>
                                    @error('notes')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Appointment ID field -->
                    <input type="hidden" name="appointment_id" value="{{ session('appointment_id') }}">

                    <div class="checkout-actions">
                        <button type="submit" class="place-order-btn">
                            تأكيد الطلب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            this.classList.add('loading');
        });
    </script>
</body>
</html>
