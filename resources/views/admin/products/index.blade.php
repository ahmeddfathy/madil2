<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/admin/products.css')}}">


    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2 class="mb-0 text-dark">Products Management</h2>
                <p class="text-muted">Manage your store products</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-action">
                    <i class="fas fa-plus me-2"></i>Add New Product
                </a>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control search-box"
                            placeholder="Search products..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select search-box">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-select search-box">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price High to Low</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price Low to High</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 btn-action">
                            <i class="fas fa-search me-2"></i>Search
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
                    <!-- Product Image -->
                    <div class="product-image-container">
                        @if($product->primary_image)
                        <img src="{{ Storage::url($product->primary_image->image_path) }}"
                            alt="{{ $product->name }}"
                            class="product-image" />
                        @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                        </div>
                        @endif

                        <span class="stock-badge {{ $product->stock > 10 ? 'in-stock' : ($product->stock > 0 ? 'low-stock' : 'out-of-stock') }}">
                            {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                        </span>
                    </div>

                    <!-- Product Details -->
                    <div class="product-details">
                        <span class="category-badge">
                            {{ $product->category->name }}
                        </span>
                        <h5 class="product-title">{{ $product->name }}</h5>
                        <p class="product-description">
                            {{ Str::limit($product->description, 100) }}
                        </p>
                        <div class="product-price">
                            {{ number_format($product->price / 100, 2) }} SAR
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-between gap-2">
                            <!-- View Button -->
                            <a href="{{ route('admin.products.show', $product) }}"
                                class="btn btn-outline-info btn-action flex-grow-1">
                                <i class="fas fa-eye"></i>
                                <span>View</span>
                            </a>

                            <!-- Edit Button -->
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="btn btn-outline-primary btn-action flex-grow-1">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.products.destroy', $product) }}"
                                method="POST"
                                class="flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-outline-danger btn-action w-100"
                                    onclick="return confirm('Are you sure you want to delete this product?');">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-box-open me-2"></i>No products found
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
