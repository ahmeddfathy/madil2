<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $product->name }}
      </h2>
      <div class="flex items-center space-x-4">
        <a href="{{ route('products.index') }}"
          class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
          Back to Products
        </a>
        <a href="{{ route('cart.index') }}"
          class="relative inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50">
          <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
          Cart
          @if(count(Session::get('cart', [])) > 0)
          <span class="absolute -top-1 -right-1 bg-red-600 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs">
            {{ count(Session::get('cart', [])) }}
          </span>
          @endif
        </a>
      </div>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div class="space-y-4">
              <!-- Main Image -->
              <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200">
                <x-product-image :product="$product" size="full" class="h-full w-full object-cover object-center" />
              </div>

              <!-- Thumbnail Images -->
              @if($product->images->count() > 0)
                <div class="grid grid-cols-4 gap-4 mt-4">
                  @foreach($product->images as $image)
                    <button type="button"
                      onclick="updateMainImage('{{ Storage::url($image->image_path) }}')"
                      class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 hover:opacity-75
                        {{ $image->is_primary ? 'ring-2 ring-blue-500' : '' }}">
                      <img src="{{ Storage::url($image->image_path) }}"
                        alt="{{ $product->name }}"
                        class="h-full w-full object-cover object-center">
                    </button>
                  @endforeach
                </div>
              @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
              <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="text-sm text-gray-500">Category: {{ $product->category->name }}</p>
              </div>

              <div class="border-t border-gray-200 pt-4">
                <p class="text-3xl font-bold text-gray-900">
                  {{ number_format($product->price / 100, 2) }} SAR
                </p>
                <p class="mt-2 text-sm text-gray-500">
                  @if($product->stock > 5)
                  In Stock
                  @elseif($product->stock > 0)
                  Only {{ $product->stock }} left in stock!
                  @else
                  Out of Stock
                  @endif
                </p>
              </div>

              <div class="border-t border-gray-200 pt-4">
                <h3 class="text-sm font-medium text-gray-900">Description</h3>
                <div class="prose prose-sm mt-2 text-gray-500">
                  {{ $product->description }}
                </div>
              </div>

              @if($product->stock > 0)
              <div class="border-t border-gray-200 pt-4">
                <form action="{{ route('cart.add', $product) }}" method="POST">
                  @csrf
                  <div class="flex items-center space-x-4">
                    <div>
                      <label for="quantity" class="block text-sm font-medium text-gray-700">
                        Quantity
                      </label>
                      <input type="number" name="quantity" id="quantity"
                        value="1" min="1" max="{{ $product->stock }}"
                        class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm">
                    </div>
                    <button type="submit"
                      class="mt-6 flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                      Add to Cart
                    </button>
                  </div>
                </form>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
  function updateMainImage(src) {
    const mainImage = document.getElementById('mainImage');
    mainImage.src = src;
  }
  </script>
  @endpush
</x-app-layout>
