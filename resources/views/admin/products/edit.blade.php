<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المنتج - {{ $product->name }}</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/products.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/product-forms.css') }}">
</head>
<body>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">تعديل المنتج: {{ $product->name }}</h1>
            <div>
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-eye"></i>
                    عرض المنتج
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right"></i>
                    عودة للمنتجات
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">اسم المنتج</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name', $product->name) }}">
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">التصنيف</label>
                                <select name="category_id" class="form-control">
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
                                <input type="number" name="price" class="form-control" step="0.01"
                                       value="{{ old('price', $product->price / 100) }}">
                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">المخزون</label>
                                <input type="number" name="stock" class="form-control"
                                       value="{{ old('stock', $product->stock) }}">
                                @error('stock')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description and Images -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
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
                                        <div class="input-group">
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
                                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addNewImageInput()">
                                    <i class="fas fa-plus"></i>
                                    إضافة صورة
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Variants -->
                    <div class="row mt-4">
                        <!-- Colors -->
                        <div class="col-md-6">
                            <h5 class="mb-3">الألوان المتاحة</h5>
                            <div id="colorsContainer">
                                @forelse($product->colors as $color)
                                <div class="input-group mb-2">
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
                                    <button type="button" class="btn btn-outline-danger"
                                            onclick="this.closest('.input-group').remove()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @empty
                                <div class="input-group mb-2">
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
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addColorInput()">
                                <i class="fas fa-plus"></i>
                                إضافة لون
                            </button>
                        </div>

                        <!-- Sizes -->
                        <div class="col-md-6">
                            <h5 class="mb-3">المقاسات المتاحة</h5>
                            <div id="sizesContainer">
                                @forelse($product->sizes as $size)
                                <div class="input-group mb-2">
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
                                    <button type="button" class="btn btn-outline-danger"
                                            onclick="this.closest('.input-group').remove()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @empty
                                <div class="input-group mb-2">
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
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addSizeInput()">
                                <i class="fas fa-plus"></i>
                                إضافة مقاس
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="card-footer bg-white">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let newImageCount = 1;

        function addNewImageInput() {
            const container = document.getElementById('newImagesContainer');
            const div = document.createElement('div');
            div.className = 'mb-2';
            div.innerHTML = `
                <div class="input-group">
                    <input type="file" name="new_images[]" class="form-control" accept="image/*">
                    <div class="input-group-text">
                        <label class="mb-0">
                            <input type="radio" name="is_primary_new[${newImageCount}]" value="1" class="me-1">
                            صورة رئيسية
                        </label>
                    </div>
                    <button type="button" class="btn btn-outline-danger" onclick="this.closest('.mb-2').remove()">
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
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" name="colors[]" class="form-control" placeholder="اسم اللون">
                <input type="hidden" name="color_ids[]" value="">
                <div class="input-group-text">
                    <label class="mb-0">
                        <input type="checkbox" name="color_available[]" value="1" checked class="me-1">
                        متوفر
                    </label>
                </div>
                <button type="button" class="btn btn-outline-danger" onclick="this.closest('.input-group').remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function addSizeInput() {
            const container = document.getElementById('sizesContainer');
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" name="sizes[]" class="form-control" placeholder="المقاس">
                <input type="hidden" name="size_ids[]" value="">
                <div class="input-group-text">
                    <label class="mb-0">
                        <input type="checkbox" name="size_available[]" value="1" checked class="me-1">
                        متوفر
                    </label>
                </div>
                <button type="button" class="btn btn-outline-danger" onclick="this.closest('.input-group').remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }
    </script>
</body>
</html>
