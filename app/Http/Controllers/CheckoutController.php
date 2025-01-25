<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['items.product.images', 'items.product.category'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        \Log::info('Checkout process started', [
            'request_data' => $request->all(),
            'user_id' => Auth::id(),
            'is_authenticated' => Auth::check()
        ]);

        try {
            $validated = $request->validate([
                'shipping_address' => ['required', 'string', 'max:500'],
                'phone' => ['required', 'string', 'max:20'],
                'payment_method' => ['required', 'in:cash,card'],
                'notes' => ['nullable', 'string', 'max:1000'],
            ]);

            DB::beginTransaction();

            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

                if (!$cart || $cart->items->isEmpty()) {
                    throw new \Exception('Cart is empty');
                }

                $totalAmount = $cart->total_amount;
            } else {
                if (!session()->has('cart') || empty(session('cart'))) {
                    throw new \Exception('Session cart is empty');
                }

                $sessionCart = session('cart');
                $products = Product::whereIn('id', array_keys($sessionCart))->get();

                if ($products->isEmpty()) {
                    throw new \Exception('No products found');
                }

                $totalAmount = 0;
                foreach ($products as $product) {
                    $totalAmount += $product->price * $sessionCart[$product->id];
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'shipping_address' => $validated['shipping_address'],
                'phone' => $validated['phone'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => Order::PAYMENT_STATUS_PENDING,
                'order_status' => Order::ORDER_STATUS_PENDING,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Add order items
            if (Auth::check()) {
                foreach ($cart->items as $item) {
                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->product->price,
                        'subtotal' => $item->product->price * $item->quantity
                    ]);
                }
                // Clear cart
                $cart->items()->delete();
                $cart->delete();
            } else {
                foreach ($products as $product) {
                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $sessionCart[$product->id],
                        'unit_price' => $product->price,
                        'subtotal' => $product->price * $sessionCart[$product->id]
                    ]);
                }
                // Clear session cart
                session()->forget('cart');
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to place order: ' . $e->getMessage()]);
        }
    }
}
