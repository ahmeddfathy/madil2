<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Products') }}
      </h2>
      <div class="flex items-center space-x-4">
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
      <!-- Search and Filters -->
      <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
          <!-- Search Input -->
          <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <input type="text" name="search" id="search"
              value="{{ request('search') }}"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
              placeholder="Search products...">
          </div>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <!-- Category Filter -->
            <div>
              <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
              <select name="category" id="category"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}"
                  @selected(request('category')==$category->id)>
                  {{ $category->name }}
                </option>
                @endforeach
              </select>
            </div>

            <!-- Price Range -->
            <div>
              <label for="min_price" class="block text-sm font-medium text-gray-700">Min Price</label>
              <input type="number" name="min_price" id="min_price"
                value="{{ request('min_price') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                min="0" step="0.01">
            </div>

            <div>
              <label for="max_price" class="block text-sm font-medium text-gray-700">Max Price</label>
              <input type="number" name="max_price" id="max_price"
                value="{{ request('max_price') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                min="0" step="0.01">
            </div>
          </div>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <!-- Sort -->
            <div>
              <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
              <select name="sort" id="sort"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Default</option>
                <option value="price_asc" @selected(request('sort')==='price_asc' )>Price: Low to High</option>
                <option value="price_desc" @selected(request('sort')==='price_desc' )>Price: High to Low</option>
                <option value="newest" @selected(request('sort')==='newest' )>Newest First</option>
                <option value="popular" @selected(request('sort')==='popular' )>Most Popular</option>
              </select>
            </div>

            <!-- Items Per Page -->
            <div>
              <label for="per_page" class="block text-sm font-medium text-gray-700">Items Per Page</label>
              <select name="per_page" id="per_page"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="12" @selected(request('per_page')==12)>12</option>
                <option value="24" @selected(request('per_page')==24)>24</option>
                <option value="48" @selected(request('per_page')==48)>48</option>
              </select>
            </div>
          </div>

          <div class="flex justify-between">
            <button type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
              Apply Filters
            </button>

            @if(array_filter(request()->all()))
            <a href="{{ route('products.index') }}"
              class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
              Clear Filters
            </a>
            @endif
          </div>
        </form>
      </div>

      <!-- Products Grid -->
      <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
        @forelse($products as $product)
        <x-product-card :product="$product" />
        @empty
        <div class="col-span-full text-center py-12">
          <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
          <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria</p>
        </div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="mt-6">
        {{ $products->links() }}
      </div>
    </div>
  </div>
</x-app-layout>
