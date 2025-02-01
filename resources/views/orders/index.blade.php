<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div>
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                    {{ __('My Orders') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">Manage and track your orders</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('products.index') }}"
                    class="group inline-flex items-center px-4 py-2 bg-white border-2 border-blue-600 text-blue-600 text-sm font-medium rounded-lg hover:bg-blue-50 transition-all duration-200 ease-in-out">
                    <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Continue Shopping
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Orders
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($orders as $order)
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-6 transform transition duration-300 ease-in-out hover:shadow-2xl hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-6 mb-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center shadow-inner">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-2xl font-bold text-gray-900">
                                        Order #{{ $order->id }}
                                    </h3>
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                        @if($order->order_status === \App\Models\Order::ORDER_STATUS_COMPLETED) bg-green-100 text-green-800 border border-green-200
                                        @elseif($order->order_status === \App\Models\Order::ORDER_STATUS_CANCELLED) bg-red-100 text-red-800 border border-red-200
                                        @elseif($order->order_status === \App\Models\Order::ORDER_STATUS_PROCESSING) bg-blue-100 text-blue-800 border border-blue-200
                                        @else bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @endif">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 flex flex-col items-end">
                            <p class="text-3xl font-bold text-gray-900">
                                {{ number_format($order->total_amount / 100, 2) }} <span class="text-sm font-normal text-gray-600">SAR</span>
                            </p>
                            <a href="{{ route('orders.show', $order) }}"
                                class="mt-3 group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 ease-in-out shadow-md hover:shadow-lg">
                                <span>View Order Details</span>
                                <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($order->items->take(4) as $item)
                        <div class="group flex items-center space-x-4 p-4 rounded-xl bg-gray-50 hover:bg-blue-50 transition-all duration-200 ease-in-out border border-gray-100 hover:border-blue-100">
                            @if($item->product->images->where('is_primary', true)->first())
                            <div class="flex-shrink-0">
                                <img src="{{ Storage::url($item->product->images->where('is_primary', true)->first()->image_path) }}"
                                    alt="{{ $item->product->name }}"
                                    class="h-20 w-20 rounded-lg object-cover shadow-md group-hover:shadow-lg transition-shadow">
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors truncate">
                                    {{ $item->product->name }}
                                </p>
                                <div class="mt-1 flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <p class="text-sm text-gray-600">
                                        Qty: {{ $item->quantity }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if($order->items->count() > 4)
                        <div class="flex items-center justify-center p-4 rounded-xl bg-blue-50 border border-blue-100 cursor-pointer hover:bg-blue-100 transition-colors duration-200">
                            <div class="text-center">
                                <p class="text-sm font-medium text-blue-600">
                                    +{{ $order->items->count() - 4 }} more items
                                </p>
                                <p class="text-xs text-blue-500 mt-1">Click to view all</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl shadow-xl p-12">
                <div class="text-center">
                    <div class="mx-auto h-32 w-32 text-gray-400 bg-gradient-to-b from-gray-50 to-gray-100 rounded-full flex items-center justify-center shadow-inner">
                        <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">No Orders Yet</h3>
                    <p class="mt-2 text-gray-500 max-w-sm mx-auto">Your order history is empty. Start shopping to discover our amazing products!</p>
                    <div class="mt-8">
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center px-8 py-3 border-2 border-blue-600 text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 hover:border-blue-700 transition-all duration-200 ease-in-out shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Start Shopping Now
                        </a>
                    </div>
                </div>
            </div>
            @endforelse

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
