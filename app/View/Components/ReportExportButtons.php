<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ReportExportButtons extends Component
{
  public $type;
  public $period;

  public function __construct(string $type, string $period)
  {
    $this->type = $type;
    $this->period = $period;
  }

  public function render()
  {
    return view('components.report-export-buttons');
  }
}
