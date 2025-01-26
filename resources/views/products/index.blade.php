<?php
$categories = $categories ?? collect();
?>
<x-app-layout>
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products.css') }}">

    <!-- Hero Section -->
    <div class="relative hero-section">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://th.bing.com/th/id/R.d72b7f0dcfe17ebeadb3f808a66ea531?rik=zc1M%2bgBTc1vJHw&pid=ImgRaw&r=0"
                alt="Hero Background"
                class="w-full h-full object-cover">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 py-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-5xl font-bold mb-6 text-white">تسوق أفضل العبايات</h1>
                    <p class="text-xl text-white opacity-90 mb-8">اكتشفي مجموعتنا الحصرية من العبايات العصرية</p>
                    <a href="#products" class="inline-block bg-white text-indigo-600 px-8 py-3 rounded-full font-semibold hover:bg-opacity-90 transition-all duration-200">
                        تسوق الآن
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50" id="products">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Bar with Cart -->
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">منتجاتنا</h2>
                <a href="{{ route('cart.index') }}" class="cart-button group">
                    <svg class="w-6 h-6 text-gray-600 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="text-gray-700 group-hover:text-indigo-600">السلة</span>
                    @if(count(Session::get('cart', [])) > 0)
                    <span class="cart-count">{{ count(Session::get('cart', [])) }}</span>
                    @endif
                </a>
            </div>

            <!-- Filters Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <form action="{{ route('products.index') }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Search Input -->
                        <div class="col-span-full">
                            <div class="relative">
                                <input type="text" name="search" id="search"
                                    value="{{ request('search') }}"
                                    class="w-full pl-12 pr-4"
                                    placeholder="ابحث عن منتجات...">
                                <svg class="w-6 h-6 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category">التصنيف</label>
                            <select name="category" id="category" class="mt-1">
                                <option value="">كل التصنيفات</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category')==$category->id)>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label for="price_range">نطاق السعر</label>
                            <div class="flex items-center space-x-4 rtl:space-x-reverse mt-1">
                                <input type="range" name="min_price" id="min_price"
                                    value="{{ request('min_price', 0) }}"
                                    min="0" max="1000" step="10"
                                    class="price-range-input"
                                    oninput="this.nextElementSibling.value = this.value">
                                <output name="min_price_output" class="price-range-output">{{ request('min_price', 0) }}</output>
                                <span class="mx-2">إلى</span>
                                <input type="range" name="max_price" id="max_price"
                                    value="{{ request('max_price', 1000) }}"
                                    min="0" max="1000" step="10"
                                    class="price-range-input"
                                    oninput="this.previousElementSibling.value = this.value">
                                <output name="max_price_output" class="price-range-output">{{ request('max_price', 1000) }}</output>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label for="sort">الترتيب حسب</label>
                            <select name="sort" id="sort" class="mt-1">
                                <option value="">الافتراضي</option>
                                <option value="price_asc" @selected(request('sort')==='price_asc' )>السعر: من الأقل للأعلى</option>
                                <option value="price_desc" @selected(request('sort')==='price_desc' )>السعر: من الأعلى للأقل</option>
                                <option value="newest" @selected(request('sort')==='newest' )>الأحدث</option>
                                <option value="popular" @selected(request('sort')==='popular' )>الأكثر مبيعاً</option>
                            </select>
                        </div>

                        <!-- Items Per Page -->
                        <div>
                            <label for="per_page">عدد المنتجات في الصفحة</label>
                            <select name="per_page" id="per_page" class="mt-1">
                                <option value="12" @selected(request('per_page')==12)>12</option>
                                <option value="24" @selected(request('per_page')==24)>24</option>
                                <option value="48" @selected(request('per_page')==48)>48</option>
                            </select>
                        </div>
                    </div>

                    <div class="filter-buttons">
                        <button type="submit" class="apply-filters-btn">
                            <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            تطبيق الفلتر
                        </button>
                        @if(array_filter(request()->all()))
                        <a href="{{ route('products.index') }}" class="clear-filters-btn">
                            <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            مسح الفلتر
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="grid">
                @forelse($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover">
                        <div class="absolute top-4 right-4">
                            @if($product->is_new)
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">جديد</span>
                            @endif
                            @if($product->discount_percentage > 0)
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">{{ $product->discount_percentage }}% خصم</span>
                            @endif
                        </div>
                    </div>
                    <div class="product-details">
                        <div class="product-category">{{ $product->category->name ?? '' }}</div>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between mt-2">
                            <div class="product-price">
                                @if($product->discount_price)
                                <span class="text-red-500">{{ number_format($product->discount_price, 2) }}</span>
                                <span class="text-sm text-gray-500 line-through mr-2">{{ number_format($product->price, 2) }}</span>
                                @else
                                <span>{{ number_format($product->price, 2) }}</span>
                                @endif
                                <span class="currency">ر.س</span>
                            </div>
                        </div>
                        <button class="add-to-cart-btn mt-4">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            إضافة للسلة
                        </button>
                    </div>
                </div>
                @empty
                <div class="empty-state col-span-full">
                    <div class="empty-state-title">لم يتم العثور على منتجات</div>
                    <p class="empty-state-message">جرب تعديل معايير البحث أو الفلترة</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
