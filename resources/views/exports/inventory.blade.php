<!DOCTYPE html>
<html>

<head>
  <title>Inventory Report</title>
  <style>
    body {
      font-family: DejaVu Sans;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1rem;
    }

    .table th,
    .table td {
      padding: 0.75rem;
      border-top: 1px solid #dee2e6;
    }

    .text-right {
      text-align: right;
    }

    .metric {
      margin-bottom: 2rem;
    }

    .metric-value {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .metric-label {
      color: #6b7280;
    }
  </style>
</head>

<body>
  <h1>Inventory Status Report</h1>

  <div class="metric">
    <div class="metric-value">{{ $data['total_products'] }}</div>
    <div class="metric-label">Total Products</div>
  </div>

  <div class="metric">
    <div class="metric-value">{{ $data['low_stock_count'] }}</div>
    <div class="metric-label">Low Stock Items</div>
  </div>

  <div class="metric">
    <div class="metric-value">{{ $data['out_of_stock_count'] }}</div>
    <div class="metric-label">Out of Stock Items</div>
  </div>

  <div class="metric">
    <div class="metric-value">{{ $data['average_stock'] }}</div>
    <div class="metric-label">Average Stock Level</div>
  </div>
</body>

</html>
