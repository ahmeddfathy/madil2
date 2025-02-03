@extends('layouts.customer')

@section('title', 'سلة التسوق')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
  .cart-container {
    max-width: 1000px;
    margin: 0 auto;
  }

  .cart-item {
    background: #fff;
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    border: 1px solid #eee;
  }

  .cart-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .cart-item-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
  }

  .cart-item-details {
    flex: 1;
  }

  .cart-item-title {
    color: #333;
    font-weight: 500;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
  }

  .cart-item-price {
    color: var(--bs-primary);
    font-weight: 600;
    font-size: 1.1rem;
  }

  .cart-item-meta {
    font-size: 0.9rem;
    color: #666;
  }

  .quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .quantity-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid #ddd;
    background: #fff;
    color: #666;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }

  .quantity-btn:hover {
    background: var(--bs-primary);
    color: #fff;
    border-color: var(--bs-primary);
  }

  .quantity-input {
    width: 60px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 0.25rem;
  }

  .cart-summary {
    background: #fff;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    border: 1px solid #eee;
    position: sticky;
    top: 20px;
  }

  .summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
  }

  .summary-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
  }

  .summary-label {
    color: #666;
  }

  .summary-value {
    font-weight: 500;
    color: #333;
  }

  .total-amount {
    color: var(--bs-primary);
    font-size: 1.25rem;
    font-weight: 600;
  }

  .empty-cart {
    text-align: center;
    padding: 3rem 1rem;
  }

  .empty-cart-icon {
    font-size: 3rem;
    color: #ccc;
    margin-bottom: 1rem;
  }

  .remove-item {
    color: #dc3545;
    border: none;
    background: none;
    padding: 0;
    font-size: 1.25rem;
    opacity: 0.7;
    transition: all 0.3s ease;
  }

  .remove-item:hover {
    opacity: 1;
    transform: scale(1.1);
  }

  .checkout-btn {
    width: 100%;
    padding: 0.75rem;
    font-size: 1.1rem;
  }

  .continue-shopping {
    text-align: center;
    margin-top: 1rem;
  }

  .continue-shopping a {
    color: var(--bs-primary);
    text-decoration: none;
  }

  .continue-shopping a:hover {
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .cart-item {
      flex-direction: column;
      text-align: center;
    }

    .cart-item-image {
      margin-bottom: 1rem;
    }

    .quantity-control {
      justify-content: center;
      margin: 1rem 0;
    }

    .cart-summary {
      margin-top: 2rem;
      position: static;
    }
  }
</style>
@endsection

@section('content')
<div class="container py-4">
  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">سلة التسوق</h2>
    <span class="text-muted">{{ $cart_items_count ?? 0 }} منتجات</span>
  </div>

  <div class="cart-container">
    @if(isset($cart_items) && count($cart_items) > 0)
    <div class="row">
      <div class="col-lg-8">
        @foreach($cart_items as $item)
        <div class="cart-item d-flex gap-3">
          @php
          // Get any available image for the product, not just primary
          $productImage = $item->product->images->first();
          $imagePath = $productImage ? Storage::url($productImage->image_path) : asset('images/no-image.png');
          @endphp
          <img src="{{ $imagePath }}" alt="{{ $item->product->name }}" class="cart-item-image">
          <div class="cart-item-details">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="cart-item-title">{{ $item->product->name }}</h5>
                <div class="cart-item-meta">
                  @if($item->product->category)
                  <span class="me-2">{{ $item->product->category->name }}</span>
                  @endif
                  @if($item->size)
                  <span class="me-2">المقاس: {{ $item->size }}</span>
                  @endif
                  @if($item->color)
                  <span>اللون: {{ $item->color }}</span>
                  @endif
                </div>
              </div>
              <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="remove-item">
                  <i class="bi bi-x-circle"></i>
                </button>
              </form>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <div class="quantity-control">
                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline update-quantity-form">
                  @csrf
                  @method('PATCH')
                  <button type="button" class="quantity-btn decrease">
                    <i class="bi bi-dash"></i>
                  </button>
                  <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                    class="quantity-input" readonly>
                  <button type="button" class="quantity-btn increase">
                    <i class="bi bi-plus"></i>
                  </button>
                </form>
              </div>
              <div class="cart-item-price">
                {{ number_format($item->product->price * $item->quantity / 100, 2) }} ريال
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="col-lg-4">
        <div class="cart-summary">
          <h4 class="mb-4">ملخص الطلب</h4>
          <div class="summary-item">
            <span class="summary-label">إجمالي المنتجات</span>
            <span class="summary-value">{{ number_format($subtotal / 100, 2) }} ريال</span>
          </div>
          <div class="summary-item">
            <span class="summary-label">الشحن</span>
            <span class="summary-value">{{ number_format($shipping_cost / 100, 2) }} ريال</span>
          </div>
          @if($discount > 0)
          <div class="summary-item">
            <span class="summary-label">الخصم</span>
            <span class="summary-value text-success">- {{ number_format($discount / 100, 2) }} ريال</span>
          </div>
          @endif
          <div class="summary-item">
            <span class="summary-label">الإجمالي الكلي</span>
            <span class="total-amount">{{ number_format($total / 100, 2) }} ريال</span>
          </div>
          <a href="{{ route('checkout.index') }}" class="btn btn-primary checkout-btn">
            متابعة الشراء
          </a>
          <div class="continue-shopping mt-3">
            <a href="{{ route('products.index') }}">
              <i class="bi bi-arrow-right"></i>
              متابعة التسوق
            </a>
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="empty-cart">
      <div class="empty-cart-icon">
        <i class="bi bi-cart-x"></i>
      </div>
      <h3>السلة فارغة</h3>
      <p>لم تقم بإضافة أي منتجات إلى سلة التسوق بعد</p>
      <a href="{{ route('products.index') }}" class="btn btn-primary">
        تصفح المنتجات
      </a>
    </div>
    @endif
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // التحكم في الكمية
    document.querySelectorAll('.quantity-control').forEach(control => {
      const input = control.querySelector('.quantity-input');
      const form = control.querySelector('.update-quantity-form');
      const decreaseBtn = control.querySelector('.decrease');
      const increaseBtn = control.querySelector('.increase');

      decreaseBtn.addEventListener('click', () => {
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
          input.value = currentValue - 1;
          form.submit();
        }
      });

      increaseBtn.addEventListener('click', () => {
        input.value = parseInt(input.value) + 1;
        form.submit();
      });
    });

    // إخفاء رسائل التنبيه تلقائياً
    setTimeout(() => {
      document.querySelectorAll('.alert').forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      });
    }, 3000);
  });
</script>
@endsection
