<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/product-forms.css') }}">

    <style>
        .product-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 1rem;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 0.5rem;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .thumbnail.active {
            border-color: var(--primary);
        }

        .info-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
        }

        .info-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-title i {
            color: var(--primary);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge.in-stock {
            background: #ECFDF5;
            color: var(--success);
        }

        .status-badge.low-stock {
            background: #FFFBEB;
            color: var(--warning);
        }

        .status-badge.out-of-stock {
            background: #FEF2F2;
            color: var(--danger);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1 class="header-title">{{ $product->name }}</h1>
            <div class="header-actions">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    <span>تعديل المنتج</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                    <span>عودة للمنتجات</span>
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 mb-4">
                <div class="info-card">
                    <img src="{{ Storage::url($product->primary_image->image_path) }}"
                         alt="{{ $product->name }}"
                         class="product-image mb-3"
                         id="mainImage">

                    @if($product->images->count() > 1)
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach($product->images as $image)
                        <img src="{{ Storage::url($image->image_path) }}"
                             alt="صورة المنتج"
                             class="thumbnail {{ $image->is_primary ? 'active' : '' }}"
                             onclick="updateMainImage(this, '{{ Storage::url($image->image_path) }}')">
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <!-- Basic Information -->
                <div class="info-card">
                    <h3 class="info-title">
                        <i class="fas fa-info-circle"></i>
                        معلومات أساسية
                    </h3>
                    <div class="mb-3">
                        <span class="status-badge {{ $product->stock > 10 ? 'in-stock' : ($product->stock > 0 ? 'low-stock' : 'out-of-stock') }}">
                            @if($product->stock > 10)
                                متوفر ({{ $product->stock }})
                            @elseif($product->stock > 0)
                                مخزون منخفض ({{ $product->stock }})
                            @else
                                غير متوفر
                            @endif
                        </span>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-muted mb-1">التصنيف</div>
                            <div>{{ $product->category->name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted mb-1">السعر</div>
                            <div class="fs-4 fw-bold text-primary">{{ number_format($product->price / 100, 2) }} ريال</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted mb-1">الوصف</div>
                            <div>{{ $product->description }}</div>
                        </div>
                    </div>
                </div>

                <!-- Colors -->
                @if($product->colors && $product->colors->isNotEmpty())
                <div class="info-card">
                    <h3 class="info-title">
                        <i class="fas fa-palette"></i>
                        الألوان المتاحة
                    </h3>
                    <div class="row g-2">
                        @foreach($product->colors as $color)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2 p-2 border rounded">
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $color->color }}"></div>
                                <span>{{ $color->color }}</span>
                                <span class="ms-auto">
                                    @if($color->is_available)
                                        <i class="fas fa-check text-success"></i>
                                    @else
                                        <i class="fas fa-times text-danger"></i>
                                    @endif
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Sizes -->
                @if($product->sizes && $product->sizes->isNotEmpty())
                <div class="info-card">
                    <h3 class="info-title">
                        <i class="fas fa-ruler"></i>
                        المقاسات المتاحة
                    </h3>
                    <div class="row g-2">
                        @foreach($product->sizes as $size)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2 p-2 border rounded">
                                <span>{{ $size->size }}</span>
                                <span class="ms-auto">
                                    @if($size->is_available)
                                        <i class="fas fa-check text-success"></i>
                                    @else
                                        <i class="fas fa-times text-danger"></i>
                                    @endif
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Additional Information -->
                <div class="info-card">
                    <h3 class="info-title">
                        <i class="fas fa-clock"></i>
                        معلومات إضافية
                    </h3>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-muted mb-1">تاريخ الإضافة</div>
                            <div>{{ $product->created_at->format('Y/m/d') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted mb-1">آخر تحديث</div>
                            <div>{{ $product->updated_at->format('Y/m/d') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted mb-1">رقم المنتج</div>
                            <div>{{ $product->id }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateMainImage(thumbnail, src) {
            // تحديث الصورة الرئيسية
            document.getElementById('mainImage').src = src;

            // تحديث حالة الصور المصغرة
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }
    </script>
</body>
</html>
