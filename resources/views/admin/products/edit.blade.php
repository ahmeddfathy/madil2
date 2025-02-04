@extends('layouts.admin')

@section('title', 'تعديل المنتج - ' . $product->name)
@section('page_title', 'تعديل المنتج: ' . $product->name)

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid px-0">
            <div class="row mx-0">
                <div class="col-12 px-0">
                    <div class="products-container">
                        <!-- Header Actions -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-edit text-primary me-2"></i>
                                            تعديل المنتج
                                        </h5>
                                        <div class="actions">
                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-light-info me-2">
                                                <i class="fas fa-eye me-1"></i>
                                                عرض المنتج
                                            </a>
                                            <a href="{{ route('admin.products.index') }}" class="btn btn-light-secondary">
                                                <i class="fas fa-arrow-right me-1"></i>
                                                عودة للمنتجات
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row g-4">
                                <!-- Basic Information -->
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">
                                                <i class="fas fa-info-circle text-primary me-2"></i>
                                                معلومات أساسية
                                            </h5>
                                            <div class="mb-3">
                                                <label class="form-label">اسم المنتج</label>
                                                <input type="text" name="name" class="form-control shadow-sm"
                                                       value="{{ old('name', $product->name) }}">
                                                @error('name')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">التصنيف</label>
                                                <select name="category_id" class="form-select shadow-sm">
                                                    <option value="">اختر التصنيف</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            @selected(old('category_id', $product->category_id) == $category->id)>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">السعر (ريال)</label>
                                                <input type="number" name="price" class="form-control shadow-sm" step="0.01"
                                                       value="{{ old('price', $product->price / 100) }}">
                                                @error('price')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">المخزون</label>
                                                <input type="number" name="stock" class="form-control shadow-sm"
                                                       value="{{ old('stock', $product->stock) }}">
                                                @error('stock')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description and Images -->
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">
                                                <i class="fas fa-image text-primary me-2"></i>
                                                الوصف والصور
                                            </h5>
                                            <div class="mb-3">
                                                <label class="form-label">الوصف</label>
                                                <textarea name="description" class="form-control shadow-sm" rows="4">{{ old('description', $product->description) }}</textarea>
                                                @error('description')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Current Images -->
                                            <div class="mb-3">
                                                <label class="form-label">الصور الحالية</label>
                                                <div class="row g-2 mb-2">
                                                    @foreach($product->images as $image)
                                                    <div class="col-auto">
                                                        <div class="position-relative">
                                                            <img src="{{ Storage::url($image->image_path) }}"
                                                                 alt="صورة المنتج"
                                                                 class="rounded"
                                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                                            <div class="position-absolute top-0 end-0 p-1">
                                                                <div class="form-check">
                                                                    <input type="radio" name="is_primary" value="{{ $image->id }}"
                                                                           class="form-check-input" @checked($image->is_primary)>
                                                                </div>
                                                            </div>
                                                            <div class="position-absolute bottom-0 start-0 p-1">
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"
                                                                           class="form-check-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="small text-muted">
                                                    * حدد الصور للحذف
                                                    <br>
                                                    * اختر الصورة الرئيسية
                                                </div>
                                            </div>

                                            <!-- New Images -->
                                            <div class="mb-3">
                                                <label class="form-label">إضافة صور جديدة</label>
                                                <div id="newImagesContainer">
                                                    <div class="mb-2">
                                                        <div class="input-group shadow-sm">
                                                            <input type="file" name="new_images[]" class="form-control" accept="image/*">
                                                            <div class="input-group-text">
                                                                <label class="mb-0">
                                                                    <input type="radio" name="is_primary_new[0]" value="1" class="me-1">
                                                                    صورة رئيسية
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-light-secondary btn-sm mt-2" onclick="addNewImageInput()">
                                                    <i class="fas fa-plus"></i>
                                                    إضافة صورة
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Colors -->
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">
                                                <i class="fas fa-palette text-primary me-2"></i>
                                                الألوان المتاحة
                                            </h5>
                                            <div id="colorsContainer">
                                                @forelse($product->colors as $color)
                                                <div class="input-group mb-2 shadow-sm">
                                                    <input type="text" name="colors[]" class="form-control"
                                                           value="{{ $color->color }}" placeholder="اسم اللون">
                                                    <input type="hidden" name="color_ids[]" value="{{ $color->id }}">
                                                    <div class="input-group-text">
                                                        <label class="mb-0">
                                                            <input type="checkbox" name="color_available[]" value="1"
                                                                   @checked($color->is_available) class="me-1">
                                                            متوفر
                                                        </label>
                                                    </div>
                                                    <button type="button" class="btn btn-light-danger"
                                                            onclick="this.closest('.input-group').remove()">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                @empty
                                                <div class="input-group mb-2 shadow-sm">
                                                    <input type="text" name="colors[]" class="form-control" placeholder="اسم اللون">
                                                    <div class="input-group-text">
                                                        <label class="mb-0">
                                                            <input type="checkbox" name="color_available[]" value="1" checked class="me-1">
                                                            متوفر
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforelse
                                            </div>
                                            <button type="button" class="btn btn-light-secondary btn-sm" onclick="addColorInput()">
                                                <i class="fas fa-plus"></i>
                                                إضافة لون
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sizes -->
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">
                                                <i class="fas fa-ruler text-primary me-2"></i>
                                                المقاسات المتاحة
                                            </h5>
                                            <div id="sizesContainer">
                                                @forelse($product->sizes as $size)
                                                <div class="input-group mb-2 shadow-sm">
                                                    <input type="text" name="sizes[]" class="form-control"
                                                           value="{{ $size->size }}" placeholder="المقاس">
                                                    <input type="hidden" name="size_ids[]" value="{{ $size->id }}">
                                                    <div class="input-group-text">
                                                        <label class="mb-0">
                                                            <input type="checkbox" name="size_available[]" value="1"
                                                                   @checked($size->is_available) class="me-1">
                                                            متوفر
                                                        </label>
                                                    </div>
                                                    <button type="button" class="btn btn-light-danger"
                                                            onclick="this.closest('.input-group').remove()">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                @empty
                                                <div class="input-group mb-2 shadow-sm">
                                                    <input type="text" name="sizes[]" class="form-control" placeholder="المقاس">
                                                    <div class="input-group-text">
                                                        <label class="mb-0">
                                                            <input type="checkbox" name="size_available[]" value="1" checked class="me-1">
                                                            متوفر
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforelse
                                            </div>
                                            <button type="button" class="btn btn-light-secondary btn-sm" onclick="addSizeInput()">
                                                <i class="fas fa-plus"></i>
                                                إضافة مقاس
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>
                                                حفظ التغييرات
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/products.css') }}">
@endsection

@section('scripts')
<script>
let newImageCount = 1;

function addNewImageInput() {
    const container = document.getElementById('newImagesContainer');
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `
        <div class="input-group shadow-sm">
            <input type="file" name="new_images[]" class="form-control" accept="image/*">
            <div class="input-group-text">
                <label class="mb-0">
                    <input type="radio" name="is_primary_new[${newImageCount}]" value="1" class="me-1">
                    صورة رئيسية
                </label>
            </div>
            <button type="button" class="btn btn-light-danger" onclick="this.closest('.mb-2').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    newImageCount++;
}

function addColorInput() {
    const container = document.getElementById('colorsContainer');
    const div = document.createElement('div');
    div.className = 'input-group mb-2 shadow-sm';
    div.innerHTML = `
        <input type="text" name="colors[]" class="form-control" placeholder="اسم اللون">
        <input type="hidden" name="color_ids[]" value="">
        <div class="input-group-text">
            <label class="mb-0">
                <input type="checkbox" name="color_available[]" value="1" checked class="me-1">
                متوفر
            </label>
        </div>
        <button type="button" class="btn btn-light-danger" onclick="this.closest('.input-group').remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

function addSizeInput() {
    const container = document.getElementById('sizesContainer');
    const div = document.createElement('div');
    div.className = 'input-group mb-2 shadow-sm';
    div.innerHTML = `
        <input type="text" name="sizes[]" class="form-control" placeholder="المقاس">
        <input type="hidden" name="size_ids[]" value="">
        <div class="input-group-text">
            <label class="mb-0">
                <input type="checkbox" name="size_available[]" value="1" checked class="me-1">
                متوفر
            </label>
        </div>
        <button type="button" class="btn btn-light-danger" onclick="this.closest('.input-group').remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}
</script>
@endsection
