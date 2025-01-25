<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Notifications') }}
      </h2>
      @if($notifications->isNotEmpty())
      <form action="{{ route('notifications.mark-all-read') }}" method="POST">
        @csrf
        <button type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
          Mark All as Read
        </button>
      </form>
      @endif
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          @forelse($notifications as $notification)
          <div class="border-b border-gray-200 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0
                            {{ $notification->read_at ? 'opacity-75' : 'bg-blue-50 -mx-6 px-6' }}">
            <div class="flex justify-between items-start">
              <div>
                <h3 class="text-lg font-medium text-gray-900">
                  {{ $notification->data['title'] ?? 'Notification' }}
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                  {{ $notification->data['message'] ?? '' }}
                </p>
                <p class="mt-2 text-xs text-gray-500">
                  {{ $notification->created_at->format('F j, Y g:i A') }}
                </p>
              </div>
              @unless($notification->read_at)
              <form action="{{ route('notifications.mark-read', $notification) }}" method="POST">
                @csrf
                <button type="submit"
                  class="text-sm text-blue-600 hover:text-blue-800">
                  Mark as Read
                </button>
              </form>
              @endunless
            </div>
          </div>
          @empty
          <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
            <p class="mt-1 text-sm text-gray-500">You don't have any notifications at the moment.</p>
          </div>
          @endforelse

          <div class="mt-6">
            {{ $notifications->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
