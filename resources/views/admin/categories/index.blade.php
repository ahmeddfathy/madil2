@extends('layouts.admin')

@section('title', 'التصنيفات')
@section('page_title', 'إدارة التصنيفات')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid px-0">
            <div class="row mx-0">
                <div class="col-12 px-0">
                    <div class="categories-container">
                        <!-- Stats Cards -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm stat-card bg-gradient-primary h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white text-primary me-3">
                                                <i class="fas fa-layer-group fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1">إجمالي التصنيفات</h6>
                                                <h3 class="text-white mb-0">{{ $categories->total() }}</h3>
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
                                                <i class="fas fa-box-open fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1">إجمالي المنتجات</h6>
                                                <h3 class="text-white mb-0">{{ $categories->sum('products_count') }}</h3>
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
                                                <h3 class="text-white mb-0">{{ $categories->first()?->updated_at->format('Y/m/d') ?? 'لا يوجد' }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Header Actions -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title mb-1 d-flex align-items-center">
                                                <span class="icon-circle bg-primary text-white me-2">
                                                    <i class="fas fa-tags"></i>
                                                </span>
                                                إدارة التصنيفات
                                            </h5>
                                            <p class="text-muted mb-0 fs-sm">إدارة وتنظيم تصنيفات المنتجات</p>
                                        </div>
                                        <div class="actions">
                                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-wave">
                                                <i class="fas fa-plus me-2"></i>
                                                إضافة تصنيف جديد
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <form action="{{ route('admin.categories.index') }}" method="GET">
                                            <div class="row g-3">
                                                <div class="col-md-10">
                                                    <div class="search-wrapper">
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light border-0">
                                                                <i class="fas fa-search text-muted"></i>
                                                            </span>
                                                            <input type="text" name="search" class="form-control border-0 shadow-none ps-0"
                                                                placeholder="البحث في التصنيفات..."
                                                                value="{{ request('search') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-primary btn-wave w-100">
                                                        <i class="fas fa-search me-2"></i>
                                                        بحث
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categories Grid -->
                        <div class="row g-4">
                            @forelse($categories as $category)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-hover category-card h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="card-title h4 mb-2">{{ $category->name }}</h5>
                                                <p class="text-muted description mb-0">
                                                    {{ Str::limit($category->description, 100) ?: 'لا يوجد وصف' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                                    <i class="fas fa-box-open me-1"></i>
                                                    {{ $category->products_count }} منتج
                                                </span>
                                                <span class="text-muted small">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $category->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.categories.show', $category) }}"
                                                   class="btn btn-light-info btn-sm me-2"
                                                   title="عرض التفاصيل">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category) }}"
                                                   class="btn btn-light-primary btn-sm me-2"
                                                   title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-light-danger btn-sm"
                                                            title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-icon bg-light rounded-circle mb-3">
                                                <i class="fas fa-folder-open text-muted fa-2x"></i>
                                            </div>
                                            <h5 class="text-muted mb-3">لا توجد تصنيفات</h5>
                                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-wave">
                                                <i class="fas fa-plus me-2"></i>
                                                إضافة أول تصنيف
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($categories->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $categories->links() }}
                        </div>
                        @endif
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

.fs-sm {
    font-size: 0.875rem;
}

/* Search Styles */
.search-wrapper {
    position: relative;
}

.search-wrapper .input-group {
    background: var(--bs-light);
    border-radius: 0.5rem;
}

.input-group-text {
    border-radius: 0.5rem 0 0 0.5rem;
    padding: 0.75rem 1rem;
}

.form-control {
    border-radius: 0 0.5rem 0.5rem 0;
    padding: 0.75rem 1rem;
}

.form-control:focus {
    box-shadow: none;
    background: var(--bs-light);
}

/* Updated Card Styles */
.card {
    border-radius: 1.5rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.shadow-hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.shadow-hover:hover {
    box-shadow: 0 1rem 3rem rgba(0,0,0,0.075);
    transform: translateY(-5px);
}

.category-card {
    position: relative;
    overflow: hidden;
    background: #fff;
    border: 1px solid rgba(0,0,0,0.05) !important;
}

.category-card:hover {
    border-color: var(--primary) !important;
}

.category-card .card-title {
    color: var(--bs-dark);
    font-weight: 600;
    font-size: 1.25rem;
}

.category-card .description {
    min-height: 3rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-size: 0.95rem;
    line-height: 1.5;
    color: #6c757d;
}

.bg-primary-subtle {
    background-color: rgba(var(--primary-rgb), 0.1) !important;
}

.badge {
    font-weight: 500;
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}

.rounded-circle {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.gap-3 {
    gap: 1rem !important;
}

/* Button Styles */
.btn-wave {
    position: relative;
    overflow: hidden;
    transform: translate3d(0, 0, 0);
}

.btn-wave::after {
    content: "";
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    pointer-events: none;
    background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
    background-repeat: no-repeat;
    background-position: 50%;
    transform: scale(10, 10);
    opacity: 0;
    transition: transform .5s, opacity 1s;
}

.btn-wave:active::after {
    transform: scale(0, 0);
    opacity: .3;
    transition: 0s;
}

/* Stats Cards */
.stat-card {
    border-radius: 1rem;
    overflow: hidden;
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

/* Empty State */
.empty-icon {
    width: 80px;
    height: 80px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Dropdown Styles */
.dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
    border-radius: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: var(--bs-light);
}

.dropdown-item i {
    width: 1.25rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .categories-container {
        padding: 0.75rem;
    }

    .category-card {
        margin-bottom: 1rem;
    }

    .card-body {
        padding: 1rem !important;
    }

    .action-buttons .btn {
        width: 28px;
        height: 28px;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
    }
}

/* Action Buttons */
.action-buttons .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-light-info {
    background-color: rgba(var(--info-rgb), 0.1);
    color: var(--info);
    border: none;
}

.btn-light-info:hover {
    background-color: var(--info);
    color: white;
}

.btn-light-primary {
    background-color: rgba(var(--primary-rgb), 0.1);
    color: var(--primary);
    border: none;
}

.btn-light-primary:hover {
    background-color: var(--primary);
    color: white;
}

.btn-light-danger {
    background-color: rgba(var(--danger-rgb), 0.1);
    color: var(--danger);
    border: none;
}

.btn-light-danger:hover {
    background-color: var(--danger);
    color: white;
}
</style>
@endsection
