<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
  protected $reportService;
  protected $exportService;

  public function __construct(ReportService $reportService, ExportService $exportService)
  {
    $this->reportService = $reportService;
    $this->exportService = $exportService;
  }

  public function index(Request $request)
  {
    $period = $request->get('period', 'month');

    $salesReport = $this->reportService->getSalesReport($period);
    $topProducts = $this->reportService->getTopProducts($period);
    $appointmentsReport = $this->reportService->getAppointmentsReport($period);
    $inventoryReport = $this->reportService->getInventoryReport();

    return view('admin.reports.index', compact(
      'salesReport',
      'topProducts',
      'appointmentsReport',
      'inventoryReport',
      'period'
    ));
  }

  public function export(Request $request)
  {
    $request->validate([
      'type' => 'required|in:sales,products,inventory',
      'period' => 'required|in:week,month,year',
      'format' => 'required|in:excel,pdf'
    ]);

    $filename = $request->format === 'excel'
      ? $this->exportService->exportToExcel($request->type, $request->period)
      : $this->exportService->exportToPDF($request->type, $request->period);

    return Storage::download("public/exports/{$filename}");
  }
}
