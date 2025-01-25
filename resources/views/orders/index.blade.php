<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    @forelse($orders as $order)
                    <div class="border-b border-gray-200 pb-6 mb-6 last:border-0 last:pb-0 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    Order #{{ $order->id }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Placed on {{ $order->created_at->format('F j, Y') }}
                                </p>
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                        @if($order->order_status === \App\Models\Order::ORDER_STATUS_COMPLETED) bg-green-100 text-green-800
                                        @elseif($order->order_status === \App\Models\Order::ORDER_STATUS_CANCELLED) bg-red-100 text-red-800
                                        @elseif($order->order_status === \App\Models\Order::ORDER_STATUS_PROCESSING) bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-medium text-gray-900">
                                    {{ number_format($order->total_amount / 100, 2) }} SAR
                                </p>
                                <a href="{{ route('orders.show', $order) }}"
                                    class="inline-block mt-2 text-sm text-blue-600 hover:text-blue-800">
                                    View Details
                                </a>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach($order->items->take(4) as $item)
                            <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm">
                                @if($item->product->images->where('is_primary', true)->first())
                                <div class="flex-shrink-0">
                                    <img src="{{ Storage::url($item->product->images->where('is_primary', true)->first()->image_path) }}"
                                        alt="{{ $item->product->name }}"
                                        class="h-10 w-10 rounded object-cover">
                                </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $item->product->name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Qty: {{ $item->quantity }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                            @if($order->items->count() > 4)
                            <div class="relative flex items-center justify-center space-x-3 rounded-lg border border-gray-300 bg-white px-4 py-3 shadow-sm">
                                <p class="text-sm text-gray-500">
                                    +{{ $order->items->count() - 4 }} more items
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
                        <p class="mt-1 text-sm text-gray-500">Start shopping to place your first order!</p>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Browse Products
                            </a>
                        </div>
                    </div>
                    @endforelse

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
