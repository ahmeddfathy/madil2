<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\SearchProductsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
  public function index(SearchProductsRequest $request)
  {
    $query = Product::query()
      ->with(['category', 'images'])
      ->when($request->search, function (Builder $query, $search) {
        $query->search($search);
      })
      ->when($request->filters(), function (Builder $query, $filters) {
        $query->filter($filters);
      })
      ->when($request->min_price || $request->max_price, function (Builder $query) use ($request) {
        $query->priceRange($request->min_price, $request->max_price);
      });

    // Apply sorting
    $query->when($request->sort, function (Builder $query, $sort) {
      match ($sort) {
        'price_asc' => $query->orderBy('price', 'asc'),
        'price_desc' => $query->orderBy('price', 'desc'),
        'newest' => $query->latest(),
        'popular' => $query->withCount('orderItems')->orderByDesc('order_items_count'),
        default => $query
      };
    });

    $products = $query->paginate($request->per_page ?? 12)
      ->withQueryString();

    $categories = Category::all();
    $filters = $request->all();

    return view('products.index', compact('products', 'categories', 'filters'));
  }

  public function show(Product $product)
  {
    $product->load(['category', 'images']);
    $relatedProducts = Product::where('category_id', $product->category_id)
      ->where('id', '!=', $product->id)
      ->with(['category', 'images'])
      ->take(4)
      ->get();

    return view('products.show', compact('product', 'relatedProducts'));
  }

  public function create()
  {
    $this->authorize('create', Product::class);
    $categories = Category::all();
    return view('admin.products.create', compact('categories'));
  }

  public function store(Request $request)
  {
    $this->authorize('create', Product::class);

    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'price' => 'required|numeric|min:0',
      'stock' => 'required|integer|min:0',
      'category_id' => 'required|exists:categories,id',
      'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
      'is_primary.*' => 'boolean'
    ]);

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

    return redirect()->route('admin.products.index')
      ->with('success', 'Product created successfully.');
  }

  public function edit(Product $product)
  {
    $this->authorize('update', $product);
    $categories = Category::all();
    return view('admin.products.edit', compact('product', 'categories'));
  }

  public function update(Request $request, Product $product)
  {
    $this->authorize('update', $product);

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

    return redirect()->route('admin.products.index')
      ->with('success', 'Product updated successfully.');
  }

  public function destroy(Product $product)
  {
    $this->authorize('delete', $product);

    foreach ($product->images as $image) {
      $this->deleteFile($image->image_path);
    }

    $product->delete();

    return redirect()->route('admin.products.index')
      ->with('success', 'Product deleted successfully.');
  }
}
