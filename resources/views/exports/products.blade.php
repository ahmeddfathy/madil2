<!DOCTYPE html>
<html>

<head>
  <title>Products Report</title>
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

    .table thead th {
      vertical-align: bottom;
      border-bottom: 2px solid #dee2e6;
    }

    .text-right {
      text-align: right;
    }
  </style>
</head>

<body>
  <h1>Top Products Report - {{ ucfirst($period) }}</h1>

  <table class="table">
    <thead>
      <tr>
        <th>Product Name</th>
        <th class="text-right">Units Sold</th>
        <th class="text-right">Revenue</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $product)
      <tr>
        <td>{{ $product->name }}</td>
        <td class="text-right">{{ $product->total_quantity }}</td>
        <td class="text-right">${{ number_format($product->total_revenue, 2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
