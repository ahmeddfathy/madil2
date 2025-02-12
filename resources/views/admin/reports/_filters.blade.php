<div class="mb-8 bg-white overflow-hidden shadow-sm rounded-lg">
    <div class="p-6">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- اختيار نوع الفترة -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">نوع الفترة</label>
                    <select name="period" id="period-select"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="today" @selected(request('period') === 'today')>اليوم</option>
                        <option value="week" @selected(request('period') === 'week')>هذا الأسبوع</option>
                        <option value="month" @selected(request('period') === 'month' || !request('period'))>هذا الشهر</option>
                        <option value="year" @selected(request('period') === 'year')>هذه السنة</option>
                        <option value="custom" @selected(request('period') === 'custom')>فترة مخصصة</option>
                    </select>
                </div>

                <!-- فترة مخصصة -->
                <div class="custom-date-inputs md:col-span-2 grid grid-cols-2 gap-4" style="display: none;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">من تاريخ</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">إلى تاريخ</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- أزرار التحكم -->
                <div class="flex items-end space-x-2 rtl:space-x-reverse">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        تطبيق الفلتر
                    </button>
                    <a href="{{ route('admin.reports.index') }}"
                       class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        إلغاء الفلتر
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodSelect = document.getElementById('period-select');
    const customDateInputs = document.querySelector('.custom-date-inputs');

    function toggleCustomDateInputs() {
        customDateInputs.style.display = periodSelect.value === 'custom' ? 'grid' : 'none';
    }

    periodSelect.addEventListener('change', toggleCustomDateInputs);
    toggleCustomDateInputs(); // تشغيل الدالة عند تحميل الصفحة
});
</script>
@endpush
