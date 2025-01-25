<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checkout') }}
            </h2>
            <a href="{{ route('cart.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Back to Cart
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                        @csrf

                        <!-- Add debug output -->
                        @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 text-red-500 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Order Summary -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                                <div class="space-y-4">
                                    @if(Auth::check() && isset($cart))
                                        @foreach($cart->items as $item)
                                        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                            <div class="flex items-center space-x-4">
                                                <x-product-image :product="$item->product" size="16" />
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h4>
                                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                                </div>
                                            </div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ number_format($item->subtotal / 100, 2) }} SAR
                                            </p>
                                        </div>
                                        @endforeach
                                    @else
                                        @foreach($products as $product)
                                        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                            <div class="flex items-center space-x-4">
                                                @if($product->primary_image)
                                                    <img src="{{ Storage::url($product->primary_image->image_path) }}"
                                                        alt="{{ $product->name }}"
                                                        class="w-16 h-16 object-cover rounded">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $product->name }}</h4>
                                                    <p class="text-sm text-gray-500">Qty: {{ $sessionCart[$product->id] }}</p>
                                                </div>
                                            </div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ number_format($product->price * $sessionCart[$product->id] / 100, 2) }} SAR
                                            </p>
                                        </div>
                                        @endforeach
                                    @endif

                                    <div class="border-t border-gray-200 pt-4">
                                        <div class="flex justify-between">
                                            <p class="text-base font-medium text-gray-900">Total</p>
                                            <p class="text-base font-medium text-gray-900">
                                                @if(Auth::check() && isset($cart))
                                                    {{ number_format($cart->total_amount / 100, 2) }} SAR
                                                @else
                                                    {{ number_format($total / 100, 2) }} SAR
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h3>
                                <div class="space-y-6">
                                    <div>
                                        <label for="shipping_address" class="block text-sm font-medium text-gray-700">
                                            Shipping Address
                                        </label>
                                        <textarea name="shipping_address" id="shipping_address" rows="4"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                            required>{{ old('shipping_address', Auth::user()->address ?? '') }}</textarea>
                                        @error('shipping_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700">
                                            Phone Number
                                        </label>
                                        <input type="tel" name="phone" id="phone"
                                            value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                            required>
                                        @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Payment Method -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            Payment Method
                                        </label>
                                        <div class="mt-2 space-y-2">
                                            <div class="flex items-center">
                                                <input type="radio" name="payment_method" id="payment_cash" value="cash"
                                                    class="h-4 w-4 text-blue-600 border-gray-300"
                                                    {{ old('payment_method') == 'cash' ? 'checked' : '' }} required>
                                                <label for="payment_cash" class="ml-2 text-sm text-gray-700">
                                                    Cash on Delivery
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" name="payment_method" id="payment_card" value="card"
                                                    class="h-4 w-4 text-blue-600 border-gray-300"
                                                    {{ old('payment_method') == 'card' ? 'checked' : '' }} required>
                                                <label for="payment_card" class="ml-2 text-sm text-gray-700">
                                                    Credit/Debit Card
                                                </label>
                                            </div>
                                        </div>
                                        @error('payment_method')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700">
                                            Order Notes (Optional)
                                        </label>
                                        <textarea name="notes" id="notes" rows="4"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                                        @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                                Place Order
                            </button>
                        </div>
                    </form>

                    <!-- Add debug JavaScript -->
                    <script>
                        document.getElementById('checkout-form').addEventListener('submit', function(e) {
                            // e.preventDefault(); // uncomment to prevent form submission for testing
                            console.log('Form submitted', {
                                shipping_address: document.getElementById('shipping_address').value,
                                phone: document.getElementById('phone').value,
                                payment_method: document.querySelector('input[name="payment_method"]:checked')?.value,
                                notes: document.getElementById('notes').value
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
