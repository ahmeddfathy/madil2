<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Appointment Details') }}
      </h2>
      <a href="{{ route('appointments.index') }}"
        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
        Back to Appointments
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-gray-500">Service Type</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $appointment->service_type)) }}</dd>
            </div>

            <div>
              <dt class="text-sm font-medium text-gray-500">Status</dt>
              <dd class="mt-1">
                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                    @if($appointment->status === 'completed') bg-green-100 text-green-800
                                    @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($appointment->status === 'approved') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                  {{ ucfirst($appointment->status) }}
                </span>
              </dd>
            </div>

            <div>
              <dt class="text-sm font-medium text-gray-500">Date</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $appointment->formatted_date }}</dd>
            </div>

            <div>
              <dt class="text-sm font-medium text-gray-500">Time</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $appointment->formatted_time }}</dd>
            </div>

            <div>
              <dt class="text-sm font-medium text-gray-500">Phone</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $appointment->phone }}</dd>
            </div>

            @if($appointment->notes)
            <div class="sm:col-span-2">
              <dt class="text-sm font-medium text-gray-500">Notes</dt>
              <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $appointment->notes }}</dd>
            </div>
            @endif

            <div class="sm:col-span-2">
              <dt class="text-sm font-medium text-gray-500">Created</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $appointment->created_at->format('F j, Y g:i A') }}</dd>
            </div>
          </dl>

          @if($appointment->status === 'pending')
          <div class="mt-6 flex space-x-3">
            <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" onclick="return confirm('Are you sure you want to cancel this appointment?')"
                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                Cancel Appointment
              </button>
            </form>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>