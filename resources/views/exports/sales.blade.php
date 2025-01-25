<!DOCTYPE html>
<html>

<head>
  <title>Sales Report</title>
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

    .total-row {
      font-weight: bold;
      background-color: #f8f9fa;
    }
  </style>
</head>

<body>
  <h1>Sales Report - {{ ucfirst($period) }}</h1>

  <table class="table">
    <thead>
      <tr>
        <th>Date</th>
        <th class="text-right">Orders</th>
        <th class="text-right">Sales</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data['daily_sales'] as $date => $sales)
      <tr>
        <td>{{ $date }}</td>
        <td class="text-right">{{ $data['orders_count'] }}</td>
        <td class="text-right">${{ number_format($sales, 2) }}</td>
      </tr>
      @endforeach
      <tr class="total-row">
        <td>Total</td>
        <td class="text-right">{{ $data['orders_count'] }}</td>
        <td class="text-right">${{ number_format($data['total_sales'], 2) }}</td>
      </tr>
    </tbody>
  </table>
</body>

</html>
