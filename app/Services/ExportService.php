<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportService
{
  protected $reportService;

  public function __construct(ReportService $reportService)
  {
    $this->reportService = $reportService;
  }

  public function exportToExcel(string $type, string $period): string
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    match ($type) {
      'sales' => $this->prepareSalesSheet($sheet, $period),
      'products' => $this->prepareProductsSheet($sheet, $period),
      'inventory' => $this->prepareInventorySheet($sheet),
      default => throw new \InvalidArgumentException('Invalid export type')
    };

    $writer = new Xlsx($spreadsheet);
    $filename = "report_{$type}_{$period}.xlsx";
    $path = storage_path("app/public/exports/{$filename}");

    $writer->save($path);

    return $filename;
  }

  public function exportToPDF(string $type, string $period): string
  {
    $data = match ($type) {
      'sales' => $this->reportService->getSalesReport($period),
      'products' => $this->reportService->getTopProducts($period),
      'inventory' => $this->reportService->getInventoryReport(),
      default => throw new \InvalidArgumentException('Invalid export type')
    };

    $pdf = PDF::loadView("exports.{$type}", compact('data', 'period'));
    $filename = "report_{$type}_{$period}.pdf";

    Storage::put("public/exports/{$filename}", $pdf->output());

    return $filename;
  }

  protected function prepareSalesSheet($sheet, $period): void
  {
    $data = $this->reportService->getSalesReport($period);

    $sheet->setTitle('Sales Report');
    $sheet->setCellValue('A1', 'Date');
    $sheet->setCellValue('B1', 'Orders');
    $sheet->setCellValue('C1', 'Sales');

    $row = 2;
    foreach ($data['daily_sales'] as $date => $sales) {
      $sheet->setCellValue("A{$row}", $date);
      $sheet->setCellValue("B{$row}", $data['orders_count']);
      $sheet->setCellValue("C{$row}", $sales);
      $row++;
    }
  }

  protected function prepareProductsSheet($sheet, $period): void
  {
    $products = $this->reportService->getTopProducts($period, 20);

    $sheet->setTitle('Products Report');
    $sheet->setCellValue('A1', 'Product Name');
    $sheet->setCellValue('B1', 'Units Sold');
    $sheet->setCellValue('C1', 'Revenue');

    $row = 2;
    foreach ($products as $product) {
      $sheet->setCellValue("A{$row}", $product->name);
      $sheet->setCellValue("B{$row}", $product->total_quantity);
      $sheet->setCellValue("C{$row}", $product->total_revenue);
      $row++;
    }
  }

  protected function prepareInventorySheet($sheet): void
  {
    $data = $this->reportService->getInventoryReport();

    $sheet->setTitle('Inventory Report');
    $sheet->setCellValue('A1', 'Metric');
    $sheet->setCellValue('B1', 'Value');

    $metrics = [
      'Total Products' => $data['total_products'],
      'Low Stock Items' => $data['low_stock_count'],
      'Out of Stock' => $data['out_of_stock_count'],
      'Average Stock' => $data['average_stock']
    ];

    $row = 2;
    foreach ($metrics as $metric => $value) {
      $sheet->setCellValue("A{$row}", $metric);
      $sheet->setCellValue("B{$row}", $value);
      $row++;
    }
  }
}
