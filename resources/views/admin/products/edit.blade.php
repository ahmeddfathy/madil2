<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Product') }}: {{ $product->name }}
      </h2>
      <a href="{{ route('admin.products.index') }}"
        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
        Back to Products
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Basic Information -->
              <div class="space-y-6">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                  <input type="text" name="name" id="name"
                    value="{{ old('name', $product->name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                  @error('name')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                  <select name="category_id" id="category_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                      @selected(old('category_id', $product->category_id) == $category->id)>
                      {{ $category->name }}
                    </option>
                    @endforeach
                  </select>
                  @error('category_id')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="price" class="block text-sm font-medium text-gray-700">Price (SAR)</label>
                  <input type="number" name="price" id="price"
                    value="{{ old('price', $product->price / 100) }}"
                    step="0.01"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                  @error('price')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                  <input type="number" name="stock" id="stock"
                    value="{{ old('stock', $product->stock) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                  @error('stock')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <!-- Description and Images -->
              <div class="space-y-6">
                <div>
                  <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                  <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $product->description) }}</textarea>
                  @error('description')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Current Images -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                  <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($product->images as $image)
                    <div class="relative group">
                      <img src="{{ Storage::url($image->image_path) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-32 object-cover rounded-lg">
                      <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                        <div class="text-white space-y-2">
                          <label class="flex items-center justify-center cursor-pointer">
                            <input type="radio" name="is_primary" value="{{ $image->id }}"
                              @checked($image->is_primary)
                            class="text-blue-600 border-gray-300 rounded">
                            <span class="ml-2">Primary</span>
                          </label>
                          <label class="flex items-center justify-center cursor-pointer">
                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"
                              class="text-red-600 border-gray-300 rounded">
                            <span class="ml-2">Remove</span>
                          </label>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>

                <!-- New Images -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">Add New Images</label>
                  <div class="mt-2 space-y-4">
                    <div class="image-upload-container">
                      <div class="flex items-center space-x-4 mb-4">
                        <input type="file" name="new_images[]" accept="image/*"
                          class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div>
                          <label class="inline-flex items-center">
                            <input type="radio" name="is_primary_new[0]" value="1" class="text-blue-600 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">Primary Image</span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <button type="button" onclick="addImageUpload()"
                      class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                      + Add Another Image
                    </button>
                  </div>
                  @error('new_images.*')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>

            <div class="mt-6 border-t border-gray-200 pt-6">
              <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Update Product
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    let imageUploadCount = 1;

    function addImageUpload() {
      const container = document.querySelector('.image-upload-container');
      const newUpload = document.createElement('div');
      newUpload.className = 'flex items-center space-x-4 mb-4';
      newUpload.innerHTML = `
                <input type="file" name="new_images[]" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <div>
                    <label class="inline-flex items-center">
                        <input type="radio" name="is_primary_new[${imageUploadCount}]" value="1" class="text-blue-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Primary Image</span>
                    </label>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    Remove
                </button>
            `;
      container.appendChild(newUpload);
      imageUploadCount++;
    }
  </script>
  @endpush
</x-app-layout>
