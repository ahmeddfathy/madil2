<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات - Madil Admin</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/products.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Styles -->

</head>
<body>
    <!-- Navigation -->

    <!-- Main Content -->
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2>إدارة المنتجات</h2>
                <p>قم بإدارة وتنظيم منتجات متجرك</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-action">
                    <i class="fas fa-plus"></i>
                    <span>إضافة منتج جديد</span>
                </a>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="form-control search-box"
                                placeholder="ابحث عن المنتجات..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select search-box">
                            <option value="">جميع الفئات</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-select search-box">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث أولاً</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>الأقدم أولاً</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>السعر من الأعلى</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>السعر من الأقل</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-action w-100">
                            <i class="fas fa-filter"></i>
                            <span>تصفية</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="product-card">
                    <div class="product-image-container">
                        @if($product->primary_image)
                        <img src="{{ Storage::url($product->primary_image->image_path) }}"
                            alt="{{ $product->name }}"
                            class="product-image" />
                        @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                            <span>لا توجد صورة</span>
                        </div>
                        @endif

                        <span class="stock-badge {{ $product->stock > 10 ? 'in-stock' : ($product->stock > 0 ? 'low-stock' : 'out-of-stock') }}">
                            @if($product->stock > 10)
                                <i class="fas fa-check-circle"></i>
                            @elseif($product->stock > 0)
                                <i class="fas fa-exclamation-circle"></i>
                            @else
                                <i class="fas fa-times-circle"></i>
                            @endif
                            {{ $product->stock > 0 ? $product->stock . ' في المخزون' : 'نفذت الكمية' }}
                        </span>
                    </div>

                    <div class="product-details">
                        <span class="category-badge">
                            <i class="fas fa-tag"></i>
                            {{ $product->category->name }}
                        </span>
                        <h5 class="product-title">{{ $product->name }}</h5>
                        <p class="product-description">
                            {{ Str::limit($product->description, 100) }}
                        </p>
                        <div class="product-price">
                            {{ number_format($product->price / 100, 2) }}
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('admin.products.show', $product) }}"
                                class="btn btn-outline-info btn-action flex-grow-1">
                                <i class="fas fa-eye"></i>
                                <span>عرض</span>
                            </a>

                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="btn btn-outline-primary btn-action flex-grow-1">
                                <i class="fas fa-edit"></i>
                                <span>تعديل</span>
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}"
                                method="POST"
                                class="flex-grow-1 m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-outline-danger btn-action w-100"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>حذف</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert-info">
                    <i class="fas fa-box-open fa-2x mb-3"></i>
                    <p>لا توجد منتجات متاحة حالياً</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-action mt-3">
                        <i class="fas fa-plus"></i>
                        <span>إضافة منتج جديد</span>
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
