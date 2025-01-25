<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manage Products') }}
      </h2>
      <a href="{{ route('admin.products.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
        Add New Product
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Filters -->
      <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap gap-4">
          <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
              <option value="">All Categories</option>
              @foreach($categories as $category)
              <option value="{{ $category->id }}" @selected(request('category')==$category->id)>
                {{ $category->name }}
              </option>
              @endforeach
            </select>
          </div>

          <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <input type="text" name="search" id="search"
              value="{{ request('search') }}"
              placeholder="Search products..."
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          </div>

          <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
              Filter
            </button>
          </div>
        </form>
      </div>

      <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Product
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Category
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Price
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Stock
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Sales
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($products as $product)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <x-product-image :product="$product" size="16" />
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ $product->name }}
                      </div>
                      <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $product->category->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                  {{ number_format($product->price / 100, 2) }} SAR
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                  <span class="@if($product->stock <= 5) text-red-600 font-medium @else text-gray-500 @endif">
                    {{ $product->stock }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                  {{ $product->order_items_count ?? 0 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a href="{{ route('admin.products.edit', $product) }}"
                    class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                  <form action="{{ route('admin.products.destroy', $product) }}"
                    method="POST"
                    class="inline-block"
                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <div class="mt-6">
            {{ $products->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
