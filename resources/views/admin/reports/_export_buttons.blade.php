<div class="flex space-x-2">
  <form action="{{ route('admin.reports.export') }}" method="GET" class="inline">
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="period" value="{{ $period }}">
    <input type="hidden" name="format" value="excel">
    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
      Excel
    </button>
  </form>
  <span class="text-gray-300">|</span>
  <form action="{{ route('admin.reports.export') }}" method="GET" class="inline">
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="period" value="{{ $period }}">
    <input type="hidden" name="format" value="pdf">
    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
      PDF
    </button>
  </form>
</div>
