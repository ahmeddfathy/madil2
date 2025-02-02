<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج جديد</title>

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
            <h1 class="h3 mb-0">إضافة منتج جديد</h1>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right"></i>
                عودة للمنتجات
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">اسم المنتج</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">التصنيف</label>
                                <select name="category_id" class="form-control">
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
                                <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price') }}">
                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">المخزون</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
                                @error('stock')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description and Images -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">صور المنتج</label>
                                <div id="imagesContainer">
                                    <div class="mb-2">
                                        <div class="input-group">
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
                                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addImageInput()">
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
                                <div class="input-group mb-2">
                                    <input type="text" name="colors[]" class="form-control" placeholder="اسم اللون">
                                    <div class="input-group-text">
                                        <label class="mb-0">
                                            <input type="checkbox" name="color_available[]" value="1" checked class="me-1">
                                            متوفر
                                        </label>
                                    </div>
                                </div>
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
                                <div class="input-group mb-2">
                                    <input type="text" name="sizes[]" class="form-control" placeholder="المقاس">
                                    <div class="input-group-text">
                                        <label class="mb-0">
                                            <input type="checkbox" name="size_available[]" value="1" checked class="me-1">
                                            متوفر
                                        </label>
                                    </div>
                                </div>
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
                        حفظ المنتج
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let imageCount = 1;

        function addImageInput() {
            const container = document.getElementById('imagesContainer');
            const div = document.createElement('div');
            div.className = 'mb-2';
            div.innerHTML = `
                <div class="input-group">
                    <input type="file" name="images[]" class="form-control" accept="image/*">
                    <div class="input-group-text">
                        <label class="mb-0">
                            <input type="radio" name="is_primary[${imageCount}]" value="1" class="me-1">
                            صورة رئيسية
                        </label>
                    </div>
                    <button type="button" class="btn btn-outline-danger" onclick="this.closest('.mb-2').remove()">
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
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" name="colors[]" class="form-control" placeholder="اسم اللون">
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
