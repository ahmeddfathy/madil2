@extends('layouts.customer')

@section('styles')
<style>
    
    /* Modern Professional Products Page */
    .body{
        padding-top: 20px;
    }
    .main-content {
        padding-top: 150px;
        background-color: #f8f9fa;
    }

    /* Breadcrumb */
    .breadcrumb-option {
        background: linear-gradient(90deg, rgba(0,146,69,0.1) 0%, rgba(255,255,255,1) 100%);
        padding: 20px 0;
        margin-bottom: 30px;
    }

    .breadcrumb__text h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
    }

    .breadcrumb__links a {
        color: #009245;
        text-decoration: none;
        transition: all 0.3s;
    }

    .breadcrumb__links a:hover {
        color: #007d3a;
        text-decoration: underline;
    }

    /* Filter Sidebar */
    .filter-sidebar {
        position: sticky;
        top: 140px;
        height: fit-content;
    }

    .filter-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        padding: 25px;
        margin-bottom: 30px;
    }

    .filter-container h3 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
        margin-bottom: 25px;
    }

    .filter-section h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #444;
        margin-bottom: 15px;
    }

    .category-item {
        padding: 8px 0;
        transition: all 0.3s;
    }

    .category-item:hover {
        transform: translateX(-5px);
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        margin-left: 10px;
        border: 2px solid #ddd;
    }

    .form-check-input:checked {
        background-color: #009245;
        border-color: #009245;
    }

    .form-check-label {
        display: flex;
        align-items: center;
        color: #555;
        font-size: 0.95rem;
        cursor: pointer;
    }

    /* Price Range */
    .price-range-container {
        padding: 0 10px;
    }

    .form-range {
        height: 8px;
        width: 100%;
        cursor: pointer;
    }

    .form-range::-webkit-slider-thumb {
        width: 20px;
        height: 20px;
        background: #009245;
    }

    .price-range-values {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 0.9rem;
        color: #666;
    }

    /* Product Grid */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .section-header h2 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .glass-select {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 0.95rem;
        width: 220px;
    }

    #resetFiltersBtn {
        padding: 10px 15px;
        font-size: 0.95rem;
    }

    /* Product Cards */
    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        margin-bottom: 25px;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .product-image-wrapper {
        display: block;
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-details {
        padding: 20px;
    }

    .product-category {
        color: #009245;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .product-title h3 {
        color: #333;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        transition: color 0.3s;
    }

    .product-title:hover h3 {
        color: #009245;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        margin: 10px 0;
    }

    .stars {
        --percent: calc(var(--rating) / 5 * 100%);
        display: inline-block;
        font-size: 1rem;
        font-family: Times;
        line-height: 1;
    }

    .stars::before {
        content: '★★★★★';
        letter-spacing: 3px;
        background: linear-gradient(90deg, #ffc107 var(--percent), #ddd var(--percent));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .reviews {
        font-size: 0.8rem;
        color: #777;
    }

    .product-price {
        color: #009245;
        font-weight: 700;
        font-size: 1.2rem;
        margin: 15px 0;
    }

    .product-actions {
        margin-top: 15px;
    }

    .order-product-btn {
        display: block;
        background: #009245;
        color: white;
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
        font-weight: 500;
    }

    .order-product-btn:hover {
        background: #007d3a;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 146, 69, 0.3);
    }

    /* Responsive Adjustments */
    @media (max-width: 1199px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media (max-width: 991px) {
        .main-content {
            padding-top: 100px;
        }
        
        .filter-sidebar {
            position: static;
            margin-bottom: 30px;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 767px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
        }
        
        .product-image-wrapper {
            height: 200px;
        }
    }

    @media (max-width: 575px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
        
        .glass-select, #resetFiltersBtn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<!-- <div class="main-content">
    Breadcrumb Section
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>منتجاتنا</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('home') }}">الرئيسية</a>
                            <span>المنتجات</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 -->

    <!-- Main Container -->
    <div class="container py-5">
        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-3 filter-sidebar">
                <div class="filter-container">
                    <h3><i class="fas fa-filter me-2"></i>تصفية المنتجات</h3>
                    <div class="filter-section">
                        <h4><i class="fas fa-tags me-2"></i>الفئات</h4>
                        @foreach($categories as $category)
                        <div class="category-item mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    value="{{ $category->slug }}"
                                    id="category-{{ $category->id }}"
                                    name="categories[]"
                                    {{ request('category') == $category->slug ? 'checked' : '' }}>
                                <label class="form-check-label d-flex justify-content-between align-items-center"
                                    for="category-{{ $category->id }}">
                                    {{ $category->name }}
                                    <span class="badge bg-primary rounded-pill">{{ $category->products_count }}</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="filter-section">
                        <h4><i class="fas fa-money-bill-wave me-2"></i>نطاق السعر</h4>
                        <div class="form-group mb-4">
                            <label for="priceRange" class="form-label">السعر</label>
                            <div class="price-range-values">
                                <span>{{ number_format($priceRange['min']) }} ر.س</span>
                                <span id="priceValue">{{ number_format($priceRange['max']) }} ر.س</span>
                            </div>
                            <input type="range" class="form-range" id="priceRange"
                                min="{{ $priceRange['min'] }}"
                                max="{{ $priceRange['max'] }}"
                                value="{{ $priceRange['max'] }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="section-header mb-4">
                    <h2>تصفح منتجاتنا</h2>
                    <div class="d-flex gap-3 align-items-center">
                        <select class="form-select glass-select" id="sortSelect">
                            <option value="newest">الأحدث أولاً</option>
                            <option value="price-low">السعر: من الأقل للأعلى</option>
                            <option value="price-high">السعر: من الأعلى للأقل</option>
                        </select>
                        <button onclick="resetFilters()" class="btn btn-outline-primary" id="resetFiltersBtn">
                            <i class="fas fa-times-circle me-2"></i>
                            إعادة تعيين
                        </button>
                    </div>
                </div>
                <div class="row" id="productGrid">
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card">
                            <a href="{{ route('products.show', $product->slug) }}" class="product-image-wrapper">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ url('storage/' . $product->images->first()->image_path) }}"
                                         alt="{{ $product->name }}"
                                         class="product-image">
                                @else
                                    <img src="{{ url('images/placeholder.jpg') }}"
                                         alt="{{ $product->name }}"
                                         class="product-image">
                                @endif
                                @if($product->is_new)
                                <span class="badge bg-success position-absolute top-10 start-10">جديد</span>
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
                                <p class="product-price">
                                    @if($product->min_price == $product->max_price)
                                        {{ number_format($product->min_price, 2) }} ر.س
                                    @else
                                        {{ number_format($product->min_price, 2) }} - {{ number_format($product->max_price, 2) }} ر.س
                                    @endif
                                </p>
                                <div class="product-actions">
                                    <a href="{{ route('products.show', $product->slug) }}" class="order-product-btn">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        عرض المنتج
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
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Price range filter
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        
        if (priceRange && priceValue) {
            priceRange.addEventListener('input', function() {
                priceValue.textContent = numberFormat(this.value) + ' ر.س';
            });
        }

        // Number formatting helper
        function numberFormat(number) {
            return new Intl.NumberFormat().format(number);
        }

        // Filter products
        const filterInputs = document.querySelectorAll('input[name="categories[]"], #priceRange, #sortSelect');
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                filterProducts();
            });
        });

        function filterProducts() {
            const categories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked')).map(el => el.value);
            const maxPrice = document.getElementById('priceRange').value;
            const sortBy = document.getElementById('sortSelect').value;
            
            axios.post("{{ route('products.filter') }}", {
                categories: categories,
                max_price: maxPrice,
                sort_by: sortBy
            })
            .then(response => {
                document.getElementById('productGrid').innerHTML = response.data.html;
            })
            .catch(error => {
                console.error('Error filtering products:', error);
            });
        }

        function resetFilters() {
            document.querySelectorAll('input[name="categories[]"]').forEach(input => {
                input.checked = false;
            });
            
            document.getElementById('priceRange').value = "{{ $priceRange['max'] }}";
            document.getElementById('priceValue').textContent = numberFormat("{{ $priceRange['max'] }}") + ' ر.س';
            document.getElementById('sortSelect').value = 'newest';
            
            filterProducts();
        }
    });
</script>
@endsection