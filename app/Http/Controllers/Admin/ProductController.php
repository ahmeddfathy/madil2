<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])
            ->withCount('orderItems');

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'is_primary.*' => 'boolean',
            'colors' => 'array|nullable',
            'colors.*' => 'string|max:255',
            'color_available' => 'array|nullable',
            'color_available.*' => 'boolean',
            'sizes' => 'array|nullable',
            'sizes.*' => 'string|max:255',
            'size_available' => 'array|nullable',
            'size_available.*' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $validatedData['slug'] = Str::slug($validatedData['name']);
            $product = Product::create($validatedData);

            // Store colors
            if ($request->has('colors')) {
                foreach ($request->colors as $index => $color) {
                    if (!empty($color)) {
                        $product->colors()->create([
                            'color' => $color,
                            'is_available' => $request->color_available[$index] ?? true
                        ]);
                    }
                }
            }

            // Store sizes
            if ($request->has('sizes')) {
                foreach ($request->sizes as $index => $size) {
                    if (!empty($size)) {
                        $product->sizes()->create([
                            'size' => $size,
                            'is_available' => $request->size_available[$index] ?? true
                        ]);
                    }
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $this->uploadFile($image, 'products');
                    $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => $request->input('is_primary.' . $index, false)
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create product. ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'colors', 'sizes']);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'new_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'is_primary.*' => 'boolean',
            'remove_images.*' => 'exists:product_images,id',
            'colors' => 'array|nullable',
            'colors.*' => 'string|max:255',
            'color_ids.*' => 'nullable|exists:product_colors,id',
            'color_available.*' => 'boolean',
            'sizes' => 'array|nullable',
            'sizes.*' => 'string|max:255',
            'size_ids.*' => 'nullable|exists:product_sizes,id',
            'size_available.*' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $validated['slug'] = Str::slug($validated['name']);
            $product->update($validated);

            // Update colors
            if ($request->has('colors')) {
                // Get current color IDs for later comparison
                $currentColorIds = $product->colors->pluck('id')->toArray();
                $updatedColorIds = array_filter($request->color_ids ?? []);

                // Remove colors that are no longer present
                $deletedColorIds = array_diff($currentColorIds, $updatedColorIds);
                if (!empty($deletedColorIds)) {
                    $product->colors()->whereIn('id', $deletedColorIds)->delete();
                }

                // Update or create colors
                foreach ($request->colors as $index => $colorName) {
                    if (!empty($colorName)) {
                        $colorId = $request->color_ids[$index] ?? null;
                        $colorData = [
                            'color' => $colorName,
                            'is_available' => $request->color_available[$index] ?? true
                        ];

                        if ($colorId) {
                            $product->colors()->where('id', $colorId)->update($colorData);
                        } else {
                            $product->colors()->create($colorData);
                        }
                    }
                }
            }

            // Update sizes
            if ($request->has('sizes')) {
                // Get current size IDs for later comparison
                $currentSizeIds = $product->sizes->pluck('id')->toArray();
                $updatedSizeIds = array_filter($request->size_ids ?? []);

                // Remove sizes that are no longer present
                $deletedSizeIds = array_diff($currentSizeIds, $updatedSizeIds);
                if (!empty($deletedSizeIds)) {
                    $product->sizes()->whereIn('id', $deletedSizeIds)->delete();
                }

                // Update or create sizes
                foreach ($request->sizes as $index => $sizeName) {
                    if (!empty($sizeName)) {
                        $sizeId = $request->size_ids[$index] ?? null;
                        $sizeData = [
                            'size' => $sizeName,
                            'is_available' => $request->size_available[$index] ?? true
                        ];

                        if ($sizeId) {
                            $product->sizes()->where('id', $sizeId)->update($sizeData);
                        } else {
                            $product->sizes()->create($sizeData);
                        }
                    }
                }
            }

            // Handle image removals
            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageId) {
                    $image = $product->images()->find($imageId);
                    if ($image) {
                        $this->deleteFile($image->image_path);
                        $image->delete();
                    }
                }
            }

            // Handle new images
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $index => $image) {
                    $path = $this->uploadFile($image, 'products');
                    $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => $request->input('is_primary.' . $index, false)
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update product. ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Delete all associated images
            foreach ($product->images as $image) {
                $this->deleteFile($image->image_path);
            }

            $product->delete();

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete product. ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'colors', 'sizes', 'orderItems']);
        return view('admin.products.show', compact('product'));
    }
}
