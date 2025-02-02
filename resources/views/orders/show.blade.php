<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الطلب #{{ $order->id }}</title>
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/orders.css') }}">
</head>
<body>
    <header class="header-container">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="page-title">تفاصيل الطلب #{{ $order->id }}</h2>
                <a href="/orders" class="btn btn-secondary">
                    <i class="bi bi-arrow-right"></i>
                    العودة للطلبات
                </a>
            </div>
        </div>
    </header>

    <main class="container py-4">
        <div class="order-card">
            <div class="order-header">
                <div class="status-section">
                    <h3 class="section-title">حالة الطلب</h3>
                    <span class="status-badge status-{{ $order->order_status }}">
                        {{ $order->order_status === 'completed' ? 'مكتمل' :
                           ($order->order_status === 'cancelled' ? 'ملغي' :
                           ($order->order_status === 'processing' ? 'قيد المعالجة' : 'معلق')) }}
                    </span>
                </div>
                @if($order->notes)
                <div class="order-notes mt-3">
                    <h4>ملاحظات:</h4>
                    <p>{{ $order->notes }}</p>
                </div>
                @endif
            </div>

            <div class="order-details">
                <div class="row">
                    <!-- معلومات الشحن -->
                    <div class="col-md-6">
                        <div class="info-group">
                            <h3 class="section-title">معلومات الشحن</h3>
                            <div class="shipping-info">
                                <div class="info-item">
                                    <span class="info-label">العنوان:</span>
                                    <span class="info-value">{{ $order->shipping_address }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">رقم الهاتف:</span>
                                    <span class="info-value">{{ $order->phone }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ملخص الطلب -->
                    <div class="col-md-6">
                        <div class="info-group">
                            <h3 class="section-title">ملخص الطلب</h3>
                            <div class="order-items">
                                @foreach($order->items as $item)
                                <div class="order-item">
                                    @if($item->product->images->where('is_primary', true)->first())
                                    <img src="{{ Storage::url($item->product->images->where('is_primary', true)->first()->image_path) }}"
                                        alt="{{ $item->product->name }}"
                                        class="item-image">
                                    @endif
                                    <div class="item-details">
                                        <h4 class="item-name">{{ $item->product->name }}</h4>
                                        <p class="item-price">
                                            {{ number_format($item->unit_price / 100, 2) }} ريال × {{ $item->quantity }}
                                        </p>
                                        <p class="item-subtotal">
                                            الإجمالي: {{ number_format($item->subtotal / 100, 2) }} ريال
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="order-total mt-4">
                                <div class="d-flex justify-content-between">
                                    <h4>الإجمالي الكلي:</h4>
                                    <span class="total-amount">{{ number_format($order->total_amount / 100, 2) }} ريال</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</body>
</html>
