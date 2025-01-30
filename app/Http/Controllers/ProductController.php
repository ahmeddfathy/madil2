<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchProductsRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->with(['category', 'images', 'colors', 'sizes'])
            ->when($request->search, function (Builder $query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->category, function (Builder $query, $category) {
                $query->whereHas('category', function($q) use ($category) {
                    $q->where('name', $category);
                });
            })
            ->when($request->max_price, function (Builder $query, $maxPrice) {
                $query->where('price', '<=', $maxPrice);
            });

        // Apply sorting
        $query->when($request->sort, function (Builder $query, $sort) {
            match ($sort) {
                'price-low' => $query->orderBy('price', 'asc'),
                'price-high' => $query->orderBy('price', 'desc'),
                'newest' => $query->latest(),
                default => $query->orderBy('created_at', 'desc')
            };
        });

        $products = $query->paginate($request->per_page ?? 12);

        $categories = Category::select('id', 'name')
            ->withCount('products')
            ->get();

        // Get price range for filter
        $priceRange = [
            'min' => Product::min('price'),
            'max' => Product::max('price')
        ];

        if ($request->ajax()) {
            return response()->json([
                'products' => collect($products->items())->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'category' => $product->category->name,
                        'price' => number_format($product->price, 2),
                        'image_url' => $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : asset('images/placeholder.jpg'),
                        'images' => collect($product->images)->map(function($image) {
                            return asset('storage/' . $image->image_path);
                        })->toArray(),
                        'colors' => collect($product->colors)->map(function($color) {
                            return [
                                'name' => $color->color,
                                'is_available' => $color->is_available
                            ];
                        })->toArray(),
                        'sizes' => collect($product->sizes)->map(function($size) {
                            return [
                                'name' => $size->size,
                                'is_available' => $size->is_available
                            ];
                        })->toArray(),
                        'rating' => $product->rating ?? 0,
                        'reviews' => $product->reviews ?? 0
                    ];
                }),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total()
                ]
            ]);
        }

        return view('products.index', compact('products', 'categories', 'priceRange'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'colors', 'sizes']);

        // Get related products from same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'images'])
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function filter(Request $request)
    {
        $query = Product::with(['category', 'images', 'colors', 'sizes']);

        // Filter by categories
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Apply sorting
        if ($request->has('sort')) {
            match ($request->sort) {
                'price-low' => $query->orderBy('price', 'asc'),
                'price-high' => $query->orderBy('price', 'desc'),
                'newest' => $query->latest(),
                'featured' => $query->where('featured', true),
                default => $query->orderBy('created_at', 'desc')
            };
        }

        $products = $query->paginate($request->per_page ?? 12);

        return response()->json([
            'products' => collect($products->items())->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'price' => number_format($product->price, 2),
                    'image_url' => $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : asset('images/placeholder.jpg'),
                    'rating' => $product->rating ?? 0,
                    'reviews' => $product->reviews ?? 0
                ];
            }),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total()
            ]
        ]);
    }

    public function getProductDetails(Product $product)
    {
        $product->load(['category', 'images', 'colors', 'sizes']);

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => number_format($product->price, 2),
            'category' => $product->category->name,
            'image_url' => $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : asset('images/placeholder.jpg'),
            'images' => collect($product->images)->map(function($image) {
                return asset('storage/' . $image->image_path);
            })->toArray(),
            'colors' => collect($product->colors)->map(function($color) {
                return [
                    'name' => $color->color,
                    'is_available' => $color->is_available
                ];
            })->toArray(),
            'sizes' => collect($product->sizes)->map(function($size) {
                return [
                    'name' => $size->size,
                    'is_available' => $size->is_available
                ];
            })->toArray(),
            'stock' => $product->stock > 0 ? 'متوفر' : 'غير متوفر'
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Get or create cart
        $cart = null;
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['session_id' => Str::random(40)]
            );
        } else {
            $sessionId = $request->session()->get('cart_session_id');
            if (!$sessionId) {
                $sessionId = Str::random(40);
                $request->session()->put('cart_session_id', $sessionId);
            }
            $cart = Cart::firstOrCreate(
                ['session_id' => $sessionId],
                ['total_amount' => 0]
            );
        }

        // Check if product already exists in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Update existing cart item
            $cartItem->quantity += $request->quantity;
            $cartItem->subtotal = $cartItem->quantity * $product->price;
            $cartItem->save();
        } else {
            // Create new cart item
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
                'subtotal' => $request->quantity * $product->price,
            ]);
        }

        // Update cart total
        $cart->total_amount = $cart->items()->sum('subtotal');
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة المنتج إلى سلة التسوق',
            'cart_count' => $cart->items()->sum('quantity'),
            'cart_total' => number_format($cart->total_amount, 2),
            'show_appointment' => true,
            'product_name' => $product->name,
            'product_id' => $product->id,
            'cart_item_id' => $cartItem->id
        ]);
    }

    public function getCartItems(Request $request)
    {
        $cart = null;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
        } else {
            $sessionId = $request->session()->get('cart_session_id');
            if ($sessionId) {
                $cart = Cart::where('session_id', $sessionId)->first();
            }
        }

        if (!$cart) {
            return response()->json([
                'items' => [],
                'total' => 0,
                'count' => 0
            ]);
        }

        $items = $cart->items()->with('product.images')->get()->map(function($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'image' => $item->product->images->first() ?
                    asset('storage/' . $item->product->images->first()->image_path) :
                    asset('images/placeholder.jpg'),
                'quantity' => $item->quantity,
                'price' => number_format($item->unit_price, 2),
                'subtotal' => number_format($item->subtotal, 2),
            ];
        });

        return response()->json([
            'items' => $items,
            'total' => number_format($cart->total_amount, 2),
            'count' => $cart->items()->sum('quantity')
        ]);
    }

    public function updateCartItem(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem->quantity = $request->quantity;
        $cartItem->subtotal = $cartItem->quantity * $cartItem->unit_price;
        $cartItem->save();

        // Update cart total
        $cart = $cartItem->cart;
        $cart->total_amount = $cart->items()->sum('subtotal');
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الكمية بنجاح',
            'item_subtotal' => number_format($cartItem->subtotal, 2),
            'cart_total' => number_format($cart->total_amount, 2),
            'cart_count' => $cart->items()->sum('quantity')
        ]);
    }

    public function removeCartItem(CartItem $cartItem)
    {
        $cart = $cartItem->cart;
        $cartItem->delete();

        // Update cart total
        $cart->total_amount = $cart->items()->sum('subtotal');
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المنتج من السلة',
            'cart_total' => number_format($cart->total_amount, 2),
            'cart_count' => $cart->items()->sum('quantity')
        ]);
    }
}
