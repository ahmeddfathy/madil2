<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلبات</title>
    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --secondary-color: #475569;
            --success-color: #059669;
            --warning-color: #d97706;
            --info-color: #0284c7;
            --danger-color: #dc2626;
            --background: #f8fafc;
            --card-background: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            background: linear-gradient(135deg, var(--background) 0%, #eef2ff 100%);
            font-family: 'Almarai', sans-serif;
            min-height: 100vh;
        }

        .main-content {
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            background: var(--card-background);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(to left, var(--card-background), #f8fafc);
            border-bottom: 1px solid var(--border-color);
            padding: 1.75rem;
            border-radius: 1.5rem 1.5rem 0 0 !important;
        }

        .card-title {
            color: var(--text-primary);
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-title i {
            color: var(--primary-color);
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            margin-top: 0;
        }

        .btn-print {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.1);
        }

        .btn-print:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-color) 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
        }

        .table-container {
            padding: 1.5rem;
            overflow-x: auto;
            border-radius: 0 0 1.5rem 1.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .table th {
            background: linear-gradient(to left, #f8fafc, #f1f5f9);
            color: var(--text-secondary);
            font-weight: 700;
            padding: 1.25rem 1rem;
            white-space: nowrap;
            border: none;
            font-size: 0.95rem;
        }

        .table td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            background-color: white;
            border: none;
            font-size: 0.95rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-radius: 1rem;
        }

        .table tbody tr:hover td {
            background-color: #f8fafc;
            transform: scale(1.01);
        }

        .avatar {
            width: 2.75rem;
            height: 2.75rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-left: 1rem;
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
            font-size: 1.1rem;
        }

        .badge {
            padding: 0.6rem 1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .badge.bg-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #10b981 100%) !important;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #f59e0b 100%) !important;
        }

        .badge.bg-info {
            background: linear-gradient(135deg, var(--info-color) 0%, #0ea5e9 100%) !important;
        }

        .badge.bg-secondary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #64748b 100%) !important;
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info-color) 0%, #0ea5e9 100%);
            border: none;
            padding: 0.6rem;
            border-radius: 0.75rem;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(2, 132, 199, 0.2);
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #0ea5e9 0%, var(--info-color) 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(2, 132, 199, 0.3);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
            background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
            border-radius: 1rem;
            margin: 1rem 0;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .empty-state p {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .pagination {
            margin: 1.5rem;
            justify-content: center;
            gap: 0.5rem;
        }

        .page-link {
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            color: var(--text-primary);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
        }

        @media print {
            body {
                background: white;
            }
            .no-print {
                display: none !important;
            }
            .card {
                box-shadow: none;
            }
            .table td, .table th {
                background: none !important;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            .card-header {
                padding: 1.25rem;
            }
            .table-container {
                padding: 1rem;
            }
            .badge {
                padding: 0.5rem 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-cart"></i>
                        قائمة الطلبات
                    </h3>
                </div>
                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <p>لا توجد طلبات حالياً</p>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>العميل</th>
                                        <th>المنتجات</th>
                                        <th>المواعيد</th>
                                        <th>الإجمالي</th>
                                        <th>حالة الطلب</th>
                                        <th>حالة الدفع</th>
                                        <th>التاريخ</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar">
                                                    {{ substr($order->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div>{{ $order->user->name }}</div>
                                                    <small class="text-muted">{{ $order->phone }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $order->items->count() }} منتج
                                            <small class="text-muted d-block">
                                                {{ $order->items->pluck('product.name')->join(' - ') }}
                                            </small>
                                        </td>
                                        <td>
                                            @php
                                                $appointmentsCount = $order->items->whereNotNull('appointment_id')->count();
                                            @endphp
                                            @if($appointmentsCount > 0)
                                                <span class="badge bg-info">{{ $appointmentsCount }} مواعيد</span>
                                            @else
                                                <span class="badge bg-secondary">لا يوجد مواعيد</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->total_amount) }} ريال</td>
                                        <td>
                                            @switch($order->order_status)
                                                @case('pending')
                                                    <span class="badge bg-warning">قيد الانتظار</span>
                                                    @break
                                                @case('processing')
                                                    <span class="badge bg-info">قيد المعالجة</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-success">مكتمل</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-secondary">ملغي</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @switch($order->payment_status)
                                                @case('pending')
                                                    <span class="badge bg-warning">قيد الانتظار</span>
                                                    @break
                                                @case('paid')
                                                    <span class="badge bg-success">تم الدفع</span>
                                                    @break
                                                @case('failed')
                                                    <span class="badge bg-secondary">فشل الدفع</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
