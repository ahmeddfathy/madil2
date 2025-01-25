<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/category.css') }}">

    <div class="categories-container">
        <!-- Header Section -->
        <div class="page-header">
            <div class="header-content">
                <div>
                    <h1 class="page-title">Categories Management</h1>
                    <p class="page-description">Manage and organize your product categories</p>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn-add-category">
                    <i class="fas fa-plus"></i>
                    <span>Add New Category</span>
                </a>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('admin.categories.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="search" class="search-input"
                            placeholder="Search categories..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn-add-category w-100">
                            <i class="fas fa-search"></i>
                            <span>Search</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Categories Grid -->
        <div class="categories-grid">
            @forelse($categories as $category)
            <div class="category-card">
                <div class="category-header">
                    <h3 class="category-title">{{ $category->name }}</h3>
                    <div class="category-stats">
                        <div class="stat-item">
                            <span class="stat-icon">
                                <i class="fas fa-box-open"></i>
                            </span>
                            <span>{{ $category->products_count }} Products</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </span>
                            <span>{{ $category->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <div class="category-actions">
                    <a href="{{ route('admin.categories.edit', $category) }}"
                        class="btn-action btn-edit">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">
                            <i class="fas fa-trash"></i>
                            <span>Delete</span>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-folder-open empty-icon"></i>
                <p class="empty-text">No categories found</p>
                <a href="{{ route('admin.categories.create') }}" class="btn-add-category">
                    <i class="fas fa-plus"></i>
                    <span>Add First Category</span>
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $categories->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
