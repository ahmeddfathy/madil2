<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Category') }}: {{ $category->name }}
      </h2>
      <a href="{{ route('admin.categories.index') }}"
        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
        Back to Categories
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" name="name" id="name"
                  value="{{ old('name', $category->name) }}"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $category->description) }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div class="border-t border-gray-200 pt-6">
                <button type="submit"
                  class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                  Update Category
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
