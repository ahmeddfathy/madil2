<div class="flex items-center space-x-4">
  <form action="{{ route('admin.reports.export') }}" method="GET" class="inline">
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="period" value="{{ $period }}">
    <input type="hidden" name="format" value="excel">
    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <span class="sr-only">Download Excel</span>
    </button>
  </form>

  <form action="{{ route('admin.reports.export') }}" method="GET" class="inline">
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="period" value="{{ $period }}">
    <input type="hidden" name="format" value="pdf">
    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
      </svg>
      <span class="sr-only">Download PDF</span>
    </button>
  </form>
</div>
