@extends('layouts.admin')

@section('title', 'إضافة منتج جديد')
@section('page_title', 'إضافة منتج جديد')

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
                                            <i class="fas fa-plus text-primary me-2"></i>
                                            إضافة منتج جديد
                                        </h5>
                                        <div class="actions">
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
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

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
                                                <input type="text" name="name" class="form-control shadow-sm" value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">التصنيف</label>
                                                <select name="category_id" class="form-select shadow-sm">
                                                    <option value="">اختر التصنيف</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
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
                                                <input type="number" name="price" class="form-control shadow-sm" value="{{ old('price') }}">
                                                @error('price')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">المخزون</label>
                                                <input type="number" name="stock" class="form-control shadow-sm" value="{{ old('stock') }}">
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
                                                <textarea name="description" class="form-control shadow-sm" rows="4">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">صور المنتج</label>
                                                <div id="imagesContainer">
                                                    <div class="mb-2">
                                                        <div class="input-group shadow-sm">
                                                            <input type="file" name="images[]" class="form-control" accept="image/*">
                                                            <div class="input-group-text">
                                                                <label class="mb-0">
                                                                    <input type="radio" name="is_primary[0]" value="1" class="me-1">
                                                                    صورة رئيسية
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-light-secondary btn-sm mt-2" onclick="addImageInput()">
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
                                                <div class="input-group mb-2 shadow-sm">
                                                    <input type="text" name="colors[]" class="form-control" placeholder="اسم اللون">
                                                    <div class="input-group-text">
                                                        <label class="mb-0">
                                                            <input type="checkbox" name="color_available[]" value="1" checked class="me-1">
                                                            متوفر
                                                        </label>
                                                    </div>
                                                </div>
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
                                                <div class="input-group mb-2 shadow-sm">
                                                    <input type="text" name="sizes[]" class="form-control" placeholder="المقاس">
                                                    <div class="input-group-text">
                                                        <label class="mb-0">
                                                            <input type="checkbox" name="size_available[]" value="1" checked class="me-1">
                                                            متوفر
                                                        </label>
                                                    </div>
                                                </div>
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
                                                حفظ المنتج
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
let imageCount = 1;

function addImageInput() {
    const container = document.getElementById('imagesContainer');
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `
        <div class="input-group shadow-sm">
            <input type="file" name="images[]" class="form-control" accept="image/*">
            <div class="input-group-text">
                <label class="mb-0">
                    <input type="radio" name="is_primary[${imageCount}]" value="1" class="me-1">
                    صورة رئيسية
                </label>
            </div>
            <button type="button" class="btn btn-light-danger" onclick="this.closest('.mb-2').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    imageCount++;
}

function addColorInput() {
    const container = document.getElementById('colorsContainer');
    const div = document.createElement('div');
    div.className = 'input-group mb-2 shadow-sm';
    div.innerHTML = `
        <input type="text" name="colors[]" class="form-control" placeholder="اسم اللون">
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
