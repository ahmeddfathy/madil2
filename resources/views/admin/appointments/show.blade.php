<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointment Details') }}
            </h2>
            <a href="{{ route('admin.appointments.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Back to Appointments
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Update Status -->
            <div class="mb-8 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status</h3>
                    <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="pending" @selected($appointment->status === 'pending')>Pending</option>
                                    <option value="approved" @selected($appointment->status === 'approved')>Approved</option>
                                    <option value="completed" @selected($appointment->status === 'completed')>Completed</option>
                                    <option value="cancelled" @selected($appointment->status === 'cancelled')>Cancelled</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $appointment->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Appointment Details -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <!-- Customer Information -->
                        <div class="sm:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->user->email }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Appointment Information -->
                        <div class="sm:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Appointment Information</h3>
                            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Service Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($appointment->service_type) }}</dd>
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
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $appointment->formatted_date }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $appointment->formatted_time }}
                                    </dd>
                                </div>

                                @if($appointment->notes)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $appointment->notes }}</dd>
                                </div>
                                @endif

                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $appointment->created_at ? $appointment->created_at->format('F j, Y g:i A') : 'Not available' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
