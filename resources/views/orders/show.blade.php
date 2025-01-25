<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Order Details') }} #{{ $order->id }}
      </h2>
      <a href="{{ route('orders.index') }}"
        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
        Back to Orders
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          <!-- Order Status -->
          <div class="mb-8">
            <div class="flex items-center space-x-2">
              <span class="text-sm font-medium text-gray-700">Status:</span>
              <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                @if($order->order_status === \App\Models\Order::ORDER_STATUS_COMPLETED) bg-green-100 text-green-800
                                @elseif($order->order_status === \App\Models\Order::ORDER_STATUS_CANCELLED) bg-red-100 text-red-800
                                @elseif($order->order_status === \App\Models\Order::ORDER_STATUS_PROCESSING) bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                {{ ucfirst($order->order_status) }}
              </span>
            </div>
            @if($order->notes)
            <div class="mt-2">
              <span class="text-sm font-medium text-gray-700">Notes:</span>
              <p class="mt-1 text-sm text-gray-600">{{ $order->notes }}</p>
            </div>
            @endif
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Shipping Information -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h3>
              <dl class="grid grid-cols-1 gap-4">
                <div>
                  <dt class="text-sm font-medium text-gray-500">Address</dt>
                  <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $order->shipping_address }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Phone</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ $order->phone }}</dd>
                </div>
              </dl>
            </div>

            <!-- Order Summary -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
              <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                  <div class="flex items-center space-x-4">
                    @if($item->product->images->where('is_primary', true)->first())
                    <img src="{{ Storage::url($item->product->images->where('is_primary', true)->first()->image_path) }}"
                      alt="{{ $item->product->name }}"
                      class="w-16 h-16 object-cover rounded">
                    @else
                    <div class="w-16 h-16 bg-gray-200 rounded"></div>
                    @endif
                    <div>
                      <h4 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h4>
                      <p class="text-sm text-gray-500">
                        {{ number_format($item->unit_price / 100, 2) }} SAR × {{ $item->quantity }}
                      </p>
                    </div>
                  </div>
                  <p class="text-sm font-medium text-gray-900">
                    {{ number_format($item->subtotal / 100, 2) }} SAR
                  </p>
                </div>
                @endforeach

                <div class="border-t border-gray-200 pt-4">
                  <div class="flex justify-between">
                    <p class="text-base font-medium text-gray-900">Total</p>
                    <p class="text-base font-medium text-gray-900">
                      {{ number_format($order->total_amount / 100, 2) }} SAR
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
