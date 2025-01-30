<x-app-layout>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/admin/products.css') }}">

  <div class="container-fluid py-4">
    <!-- Header -->
    <div class="header-wrapper">
      <div class="page-header">
        <h1 class="page-title">{{ $product->name }}</h1>
        <p class="page-subtitle">Product Details</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary btn-action">
          <i class="fas fa-edit"></i>
          <span>Edit Product</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-action">
          <i class="fas fa-arrow-left"></i>
          <span>Back to Products</span>
        </a>
      </div>
    </div>

    <div class="row g-4 mt-2">
      <!-- Product Images -->
      <div class="col-lg-6">
        <div class="product-gallery card">
          <div class="card-body">
            @if($product->images->count() > 0)
            <div class="main-image-wrapper mb-3">
              <img src="{{ Storage::url($product->primary_image->image_path) }}"
                alt="{{ $product->name }}"
                class="main-product-image">
            </div>
            @if($product->images->count() > 1)
            <div class="image-thumbnails">
              @foreach($product->images as $image)
              <div class="thumbnail-wrapper {{ $image->is_primary ? 'active' : '' }}"
                onclick="updateMainImage('{{ Storage::url($image->image_path) }}')">
                <img src="{{ Storage::url($image->image_path) }}"
                  alt="Product thumbnail"
                  class="thumbnail-image">
              </div>
              @endforeach
            </div>
            @endif
            @else
            <div class="no-image-placeholder">
              <i class="fas fa-image"></i>
              <p>No images available</p>
            </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Product Details -->
      <div class="col-lg-6">
        <div class="product-info card">
          <div class="card-body">
            <div class="info-section">
              <span class="category-badge mb-3">{{ $product->category->name }}</span>

              <div class="product-status mb-4">
                <span class="stock-badge {{ $product->stock > 10 ? 'in-stock' : ($product->stock > 0 ? 'low-stock' : 'out-of-stock') }}">
                  {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                </span>
              </div>

              <div class="product-price mb-4">
                {{ number_format($product->price / 100, 2) }} SAR
              </div>

              <div class="product-description">
                <h5 class="section-title">Description</h5>
                <p>{{ $product->description }}</p>
              </div>
            </div>

            <div class="info-section mt-4">
              <h5 class="section-title">Product Details</h5>
              <div class="details-grid">
                <div class="detail-item">
                  <span class="detail-label">SKU</span>
                  <span class="detail-value">{{ $product->id }}</span>
                </div>
                <div class="detail-item">
                  <span class="detail-label">Created</span>
                  <span class="detail-value">{{ $product->created_at->format('M d, Y') }}</span>
                </div>
                <div class="detail-item">
                  <span class="detail-label">Last Updated</span>
                  <span class="detail-value">{{ $product->updated_at->format('M d, Y') }}</span>
                </div>
                <div class="detail-item">
                  <span class="detail-label">Category</span>
                  <span class="detail-value">{{ $product->category->name }}</span>
                </div>
              </div>
            </div>

            <!-- Colors Section -->
            @if($product->colors && $product->colors->isNotEmpty())
            <div class="info-section mt-4">
              <h5 class="section-title">
                <i class="fas fa-palette me-2"></i>
                Available Colors
                <span class="badge bg-primary ms-2">{{ $product->colors->count() }}</span>
              </h5>
              <div class="colors-grid">
                @foreach($product->colors as $color)
                <div class="color-item {{ $color->is_available ? 'available' : 'unavailable' }}"
                     data-bs-toggle="tooltip"
                     title="{{ $color->is_available ? 'Available' : 'Not Available' }}">
                  <div class="d-flex align-items-center gap-2">
                    <span class="color-preview" style="background-color: {{ $color->color }}"></span>
                  <span class="color-name">{{ $color->color }}</span>
                  </div>
                  <span class="color-status">
                    @if($color->is_available)
                      <i class="fas fa-check text-success"></i>
                    @else
                      <i class="fas fa-times text-danger"></i>
                    @endif
                  </span>
                </div>
                @endforeach
              </div>
            </div>
            @endif

            <!-- Sizes Section -->
            @if($product->sizes && $product->sizes->isNotEmpty())
            <div class="info-section mt-4">
              <h5 class="section-title">
                <i class="fas fa-ruler me-2"></i>
                Available Sizes
                <span class="badge bg-primary ms-2">{{ $product->sizes->count() }}</span>
              </h5>
              <div class="sizes-grid">
                @foreach($product->sizes as $size)
                <div class="size-item {{ $size->is_available ? 'available' : 'unavailable' }}"
                     data-bs-toggle="tooltip"
                     title="{{ $size->is_available ? 'Available' : 'Not Available' }}">
                  <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-tshirt"></i>
                  <span class="size-name">{{ $size->size }}</span>
                  </div>
                  <span class="size-status">
                    @if($size->is_available)
                      <i class="fas fa-check text-success"></i>
                    @else
                      <i class="fas fa-times text-danger"></i>
                    @endif
                  </span>
                </div>
                @endforeach
              </div>
            </div>
            @endif

            @if($product->orderItems && $product->orderItems->isNotEmpty())
            <div class="info-section mt-4">
              <h5 class="section-title">Sales Statistics</h5>
              <div class="details-grid">
                <div class="detail-item">
                  <span class="detail-label">Total Orders</span>
                  <span class="detail-value">{{ $product->orderItems->count() }}</span>
                </div>
                <div class="detail-item">
                  <span class="detail-label">Total Units Sold</span>
                  <span class="detail-value">{{ $product->orderItems->sum('quantity') }}</span>
                </div>
                <div class="detail-item">
                  <span class="detail-label">Total Revenue</span>
                  <span class="detail-value">{{ number_format($product->orderItems->sum('total') / 100, 2) }} SAR</span>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .product-gallery {
      background: white;
      border-radius: 12px;
      overflow: hidden;
    }

    .main-image-wrapper {
      position: relative;
      padding-top: 100%;
      background: #f8f9fa;
      border-radius: 8px;
      overflow: hidden;
    }

    .main-product-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .image-thumbnails {
      display: flex;
      gap: 10px;
      margin-top: 15px;
      overflow-x: auto;
      padding-bottom: 10px;
    }

    .thumbnail-wrapper {
      width: 80px;
      height: 80px;
      border-radius: 8px;
      overflow: hidden;
      cursor: pointer;
      opacity: 0.7;
      transition: all 0.3s ease;
      flex-shrink: 0;
      border: 2px solid transparent;
    }

    .thumbnail-wrapper:hover,
    .thumbnail-wrapper.active {
      opacity: 1;
      border-color: var(--primary);
    }

    .thumbnail-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .no-image-placeholder {
      height: 300px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: #f8f9fa;
      border-radius: 8px;
      color: #adb5bd;
    }

    .no-image-placeholder i {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .product-info {
      background: white;
      border-radius: 12px;
    }

    .info-section {
      padding-bottom: 1.5rem;
      margin-bottom: 1.5rem;
      border-bottom: 1px solid var(--border);
    }

    .info-section:last-child {
      padding-bottom: 0;
      margin-bottom: 0;
      border-bottom: none;
    }

    .section-title {
      display: flex;
      align-items: center;
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 1rem;
    }

    .section-title i {
      color: var(--primary);
    }

    .details-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
    }

    .detail-item {
      display: flex;
      flex-direction: column;
    }

    .detail-label {
      font-size: 0.9rem;
      color: var(--text-light);
      margin-bottom: 0.25rem;
    }

    .detail-value {
      font-size: 1rem;
      color: var(--text-dark);
      font-weight: 500;
    }

    @media (max-width: 768px) {
      .details-grid {
        grid-template-columns: 1fr;
      }
    }

    .colors-grid,
    .sizes-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 1rem;
    }

    .color-item,
    .size-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.75rem;
      border-radius: 8px;
      background: #f8f9fa;
      transition: all 0.3s ease;
      border: 1px solid #e9ecef;
    }

    .color-item:hover,
    .size-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .color-item.available,
    .size-item.available {
      border-left: 3px solid #28a745;
    }

    .color-item.unavailable,
    .size-item.unavailable {
      border-left: 3px solid #dc3545;
      opacity: 0.7;
    }

    .color-preview {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: 2px solid #dee2e6;
    }

    .color-name,
    .size-name {
      font-weight: 500;
      color: var(--text-dark);
    }

    .badge {
      font-size: 0.8rem;
      font-weight: 500;
    }

    .text-success {
      color: #28a745;
    }

    .text-danger {
      color: #dc3545;
    }
  </style>

  <script>
    function updateMainImage(src) {
      const mainImage = document.querySelector('.main-product-image');
      const thumbnails = document.querySelectorAll('.thumbnail-wrapper');

      mainImage.src = src;

      thumbnails.forEach(thumb => {
        if (thumb.querySelector('img').src === src) {
          thumb.classList.add('active');
        } else {
          thumb.classList.remove('active');
        }
      });
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      });
    });
  </script>
</x-app-layout>
