<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">{{ __('Recent Orders') }}</h3>

        @if($orders->count() > 0)
        <div class="space-y-4">
          @foreach($orders as $order)
          <div class="border p-4 rounded">
            <div class="flex justify-between items-center">
              <div>
                <p class="font-semibold">Order #{{ $order->id }}</p>
                <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
              </div>
              <div class="text-right">
                <p class="font-semibold">{{ number_format($order->total_amount / 100, 2) }} EGP</p>
                <p class="text-sm text-gray-600">Status: {{ ucfirst($order->status) }}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @else
        <p class="text-gray-600">{{ __('No orders yet.') }}</p>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>