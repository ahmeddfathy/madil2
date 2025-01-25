<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('My Appointments') }}
      </h2>
      <a href="{{ route('appointments.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
        Schedule New Appointment
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @if($appointments->isEmpty())
      <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 text-center">
        <p class="text-gray-500">You don't have any appointments yet.</p>
      </div>
      @else
      <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Service
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Date & Time
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach($appointments as $appointment)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                      {{ ucfirst(str_replace('_', ' ', $appointment->service_type)) }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                      {{ $appointment->appointment_date ? $appointment->formatted_date : 'N/A' }}
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ $appointment->appointment_time ? $appointment->formatted_time : 'N/A' }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                                @if($appointment->status === 'completed') bg-green-100 text-green-800
                                                @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                                @elseif($appointment->status === 'approved') bg-blue-100 text-blue-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                      {{ ucfirst($appointment->status) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('appointments.show', $appointment) }}"
                      class="text-blue-600 hover:text-blue-900">View</a>

                    @if($appointment->status === 'pending')
                    <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="inline ml-3">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        onclick="return confirm('Are you sure you want to cancel this appointment?')"
                        class="text-red-600 hover:text-red-900">
                        Cancel
                      </button>
                    </form>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="mt-4">
            {{ $appointments->links() }}
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</x-app-layout>