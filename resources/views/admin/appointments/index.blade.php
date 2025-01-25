<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Manage Appointments') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Filters -->
      <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="flex flex-wrap gap-4">
          <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
              <option value="">All Statuses</option>
              <option value="pending" @selected(request('status')==='pending' )>Pending</option>
              <option value="approved" @selected(request('status')==='approved' )>Approved</option>
              <option value="completed" @selected(request('status')==='completed' )>Completed</option>
              <option value="cancelled" @selected(request('status')==='cancelled' )>Cancelled</option>
            </select>
          </div>

          <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" name="date" id="date"
              value="{{ request('date') }}"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          </div>

          <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <input type="text" name="search" id="search"
              value="{{ request('search') }}"
              placeholder="Search by customer name or email..."
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          </div>

          <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
              Filter
            </button>
          </div>
        </form>
      </div>

      <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Customer
                </th>
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
                  <div class="text-sm font-medium text-gray-900">{{ $appointment->user->name }}</div>
                  <div class="text-sm text-gray-500">{{ $appointment->user->email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ ucfirst($appointment->service_type) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ $appointment->date->format('F j, Y') }}</div>
                  <div class="text-sm text-gray-500">{{ $appointment->time }}</div>
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
                  <a href="{{ route('admin.appointments.show', $appointment) }}"
                    class="text-blue-600 hover:text-blue-900">View</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <div class="mt-6">
            {{ $appointments->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>