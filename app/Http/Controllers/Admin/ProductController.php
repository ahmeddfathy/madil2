<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'price' => 'required|numeric|min:0',
      'stock' => 'required|integer|min:0',
      'category_id' => 'required|exists:categories,id',
      'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
      'is_primary.*' => 'boolean'
    ]);

    try {
      DB::beginTransaction();

      $validated['slug'] = Str::slug($validated['name']);
      $validated['price'] = $this->formatPrice($validated['price']);

      $product = Product::create($validated);

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
    $product->load('images');
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
      'remove_images.*' => 'exists:product_images,id'
    ]);

    try {
      DB::beginTransaction();

      $validated['slug'] = Str::slug($validated['name']);
      $validated['price'] = $this->formatPrice($validated['price']);

      $product->update($validated);

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
}
