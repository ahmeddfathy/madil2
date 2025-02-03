@extends('layouts.admin')

@section('title', $category->name)
@section('page_title', $category->name)

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid px-0">
            <div class="row mx-0">
                <div class="col-12 px-0">
                    <div class="categories-container">
                        <!-- Header Actions -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0 d-flex align-items-center">
                                            <span class="icon-circle bg-primary text-white me-2">
                                                <i class="fas fa-tag"></i>
                                            </span>
                                            تفاصيل التصنيف
                                        </h5>
                                        <div class="actions">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-light-primary me-2">
                                                <i class="fas fa-edit me-1"></i>
                                                تعديل التصنيف
                                            </a>
                                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light-secondary">
                                                <i class="fas fa-arrow-right me-1"></i>
                                                عودة للتصنيفات
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Cards -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm stat-card bg-gradient-primary h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white text-primary me-3">
                                                <i class="fas fa-box-open fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1">عدد المنتجات</h6>
                                                <h3 class="text-white mb-0">{{ $category->products_count }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm stat-card bg-gradient-success h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white text-success me-3">
                                                <i class="fas fa-calendar-alt fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1">تاريخ الإنشاء</h6>
                                                <h3 class="text-white mb-0">{{ $category->created_at->format('Y/m/d') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm stat-card bg-gradient-info h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white text-info me-3">
                                                <i class="fas fa-clock fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1">آخر تحديث</h6>
                                                <h3 class="text-white mb-0">{{ $category->updated_at->format('Y/m/d') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Details -->
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4 d-flex align-items-center">
                                            <span class="icon-circle bg-primary text-white me-2">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                            معلومات التصنيف
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="detail-item mb-4">
                                                    <label class="text-muted mb-2">اسم التصنيف</label>
                                                    <h5 class="mb-0">{{ $category->name }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item mb-4">
                                                    <label class="text-muted mb-2">الوصف</label>
                                                    <h5 class="mb-0">{{ $category->description ?: 'لا يوجد وصف' }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Products -->
                            @if($category->products->isNotEmpty())
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4 d-flex align-items-center">
                                            <span class="icon-circle bg-primary text-white me-2">
                                                <i class="fas fa-box"></i>
                                            </span>
                                            منتجات التصنيف
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="border-0">#</th>
                                                        <th class="border-0">المنتج</th>
                                                        <th class="border-0">السعر</th>
                                                        <th class="border-0">المخزون</th>
                                                        <th class="border-0">الحالة</th>
                                                        <th class="border-0">الإجراءات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($category->products as $product)
                                                    <tr>
                                                        <td>{{ $product->id }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @if($product->image)
                                                                <img src="{{ asset($product->image) }}" class="rounded-circle me-2" width="40" height="40">
                                                                @else
                                                                <div class="no-image rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                                    <i class="fas fa-image text-muted"></i>
                                                                </div>
                                                                @endif
                                                                <div>{{ $product->name }}</div>
                                                            </div>
                                                        </td>
                                                        <td>{{ number_format($product->price / 100, 2) }} ريال</td>
                                                        <td>{{ $product->stock }}</td>
                                                        <td>
                                                            <span class="badge rounded-pill {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                                                {{ $product->stock > 10 ? 'متوفر' : ($product->stock > 0 ? 'مخزون منخفض' : 'غير متوفر') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-light-info">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.categories-container {
    padding: 1.5rem;
    width: 100%;
}

.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.bg-gradient-primary {
    background: linear-gradient(45deg, var(--primary), #4e73df);
}

.bg-gradient-success {
    background: linear-gradient(45deg, var(--success), #1cc88a);
}

.bg-gradient-info {
    background: linear-gradient(45deg, var(--info), #36b9cc);
}

.btn-light-primary {
    background-color: var(--primary-light);
    color: var(--primary);
    border: none;
}

.btn-light-primary:hover {
    background-color: var(--primary);
    color: white;
}

.btn-light-secondary {
    background-color: var(--secondary-light);
    color: var(--secondary);
    border: none;
}

.btn-light-secondary:hover {
    background-color: var(--secondary);
    color: white;
}

.btn-light-info {
    background-color: var(--info-light);
    color: var(--info);
    border: none;
}

.btn-light-info:hover {
    background-color: var(--info);
    color: white;
}

.detail-item label {
    font-size: 0.875rem;
}

.no-image {
    width: 40px;
    height: 40px;
    background-color: #f8f9fa;
}

.table th {
    font-weight: 600;
}

.badge {
    padding: 0.5em 1em;
}

@media (max-width: 768px) {
    .categories-container {
        padding: 0.75rem;
    }

    .stat-card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
