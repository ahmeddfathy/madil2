<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Schedule Appointment') }}
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
                    <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="appointment_date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="appointment_date" id="appointment_date"
                                    value="{{ old('appointment_date') }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('appointment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="appointment_time" class="block text-sm font-medium text-gray-700">Time</label>
                                <input type="time" name="appointment_time" id="appointment_time"
                                    value="{{ old('appointment_time') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('appointment_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                                <select name="service_type" id="service_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Select a service</option>
                                    <option value="new_abaya" @selected(old('service_type')==='new_abaya' )>New Abaya</option>
                                    <option value="alteration" @selected(old('service_type')==='alteration' )>Alteration</option>
                                    <option value="repair" @selected(old('service_type')==='repair' )>Repair</option>
                                </select>
                                @error('service_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="tel" name="phone" id="phone"
                                    value="{{ old('phone', auth()->user()->phone) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">الموقع</label>
                                <select name="location" id="location"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    onchange="toggleAddressField()">
                                    <option value="">اختر الموقع</option>
                                    <option value="store" @selected(old('location')==='store')>في المحل</option>
                                    <option value="client_location" @selected(old('location')==='client_location')>موقع العميل</option>
                                </select>
                                @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="addressField" class="sm:col-span-2" style="display: none;">
                                <label for="address" class="block text-sm font-medium text-gray-700">العنوان</label>
                                <textarea name="address" id="address" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('address') }}</textarea>
                                @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                                @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Schedule Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleAddressField() {
        const location = document.getElementById('location').value;
        const addressField = document.getElementById('addressField');
        addressField.style.display = location === 'client_location' ? 'block' : 'none';
    }

    // تشغيل الدالة عند تحميل الصفحة للتعامل مع القيم المحفوظة
    document.addEventListener('DOMContentLoaded', toggleAddressField);
    </script>
</x-app-layout>
