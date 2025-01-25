<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      $cart = Cart::with(['items.product.images', 'items.product.category'])
        ->where('user_id', Auth::id())
        ->first();

      return view('cart.index', compact('cart'));
    }

    $sessionCart = Session::get('cart', []);
    if (!empty($sessionCart)) {
      $products = Product::with(['images', 'category'])
        ->whereIn('id', array_keys($sessionCart))
        ->get();

      $total = $products->sum(function ($product) use ($sessionCart) {
        return $product->price * $sessionCart[$product->id];
      });

      return view('cart.index', compact('products', 'sessionCart', 'total'));
    }

    return view('cart.index');
  }

  public function add(Request $request, Product $product)
  {
    // للمستخدمين المسجلين
    if (Auth::check()) {
      $cart = Cart::firstOrCreate([
        'user_id' => Auth::id()
      ]);

      $cartItem = $cart->items()->where('product_id', $product->id)->first();

      if ($cartItem) {
        $cartItem->increment('quantity');
        $cartItem->update([
          'subtotal' => $cartItem->quantity * $cartItem->unit_price
        ]);
      } else {
        $cart->items()->create([
          'product_id' => $product->id,
          'quantity' => 1,
          'unit_price' => $product->price,
          'subtotal' => $product->price
        ]);
      }

      // تحديث إجمالي السلة
      $cart->update([
        'total_amount' => $cart->items->sum('subtotal')
      ]);
    }
    // للزوار
    else {
      $cart = Session::get('cart', []);
      if (isset($cart[$product->id])) {
        $cart[$product->id]++;
      } else {
        $cart[$product->id] = 1;
      }
      Session::put('cart', $cart);
    }

    return back()->with('success', 'Product added to cart successfully.');
  }

  public function update(Request $request, Product $product)
  {
    $request->validate([
      'quantity' => 'required|integer|min:1'
    ]);

    $cart = Session::get('cart', []);

    if (isset($cart[$product->id])) {
      $cart[$product->id] = $request->quantity;
      Session::put('cart', $cart);
      return back()->with('success', 'Cart updated successfully.');
    }

    return back()->with('error', 'Product not found in cart.');
  }

  public function remove(Product $product)
  {
    $cart = Session::get('cart', []);

    if (isset($cart[$product->id])) {
      unset($cart[$product->id]);
      Session::put('cart', $cart);
      return back()->with('success', 'Product removed from cart.');
    }

    return back()->with('error', 'Product not found in cart.');
  }

  public function clear()
  {
    Session::forget('cart');
    return back()->with('success', 'Cart cleared successfully.');
  }

  protected function mergeCartAfterLogin($user)
  {
    $sessionCart = Session::get('cart', []);

    if (!empty($sessionCart)) {
      $cart = Cart::firstOrCreate([
        'user_id' => $user->id
      ]);

      foreach ($sessionCart as $productId => $quantity) {
        $product = Product::find($productId);

        if ($product) {
          $cart->items()->updateOrCreate(
            ['product_id' => $productId],
            [
              'quantity' => $quantity,
              'unit_price' => $product->price,
              'subtotal' => $product->price * $quantity
            ]
          );
        }
      }

      $cart->update([
        'total_amount' => $cart->items->sum('subtotal')
      ]);

      Session::forget('cart');
    }
  }
}
