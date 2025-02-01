<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الطلب #{{ $order->id }}</title>
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

        .btn-back {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #64748b 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(71, 85, 105, 0.1);
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #64748b 0%, var(--secondary-color) 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(71, 85, 105, 0.2);
        }

        .btn-print {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.1);
        }

        .btn-print:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-color) 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
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

        .card-body {
            padding: 1.75rem;
        }

        .info-box {
            background: linear-gradient(to bottom, var(--card-background), #f8fafc);
            border-radius: 1.25rem;
            padding: 1.75rem;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .info-box:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .info-box h5 {
            color: var(--text-primary);
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-box h5 i {
            color: var(--primary-color);
            font-size: 1.35rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table.table-borderless th {
            color: var(--text-secondary);
            font-weight: 600;
            padding: 1rem 0;
            font-size: 0.95rem;
        }

        .table.table-borderless td {
            padding: 1rem 0;
            color: var(--text-primary);
            font-size: 0.95rem;
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

        .table-responsive {
            border-radius: 1.25rem;
            background: linear-gradient(to bottom, var(--card-background), #f8fafc);
            padding: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .table-responsive .table {
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .table-responsive .table th {
            background: linear-gradient(to left, #f8fafc, #f1f5f9);
            color: var(--text-secondary);
            font-weight: 700;
            padding: 1.25rem 1rem;
            white-space: nowrap;
            border: none;
            font-size: 0.95rem;
        }

        .table-responsive .table td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            background-color: white;
            border: none;
            font-size: 0.95rem;
        }

        .table-responsive .table tbody tr {
            transition: all 0.3s ease;
            border-radius: 1rem;
        }

        .table-responsive .table tbody tr:hover td {
            background-color: #f8fafc;
            transform: scale(1.01);
        }

        tfoot tr {
            border-top: 2px solid var(--border-color);
        }

        tfoot th, tfoot td {
            font-weight: 700 !important;
            color: var(--primary-color) !important;
            font-size: 1.1rem !important;
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
            .info-box {
                border: 1px solid var(--border-color);
                box-shadow: none;
                transform: none;
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
            .info-box {
                padding: 1.25rem;
            }
            .table-responsive {
                padding: 1rem;
            }
            .badge {
                padding: 0.5rem 0.75rem;
            }
        }

        /* إضافة ستايلات جديدة */
        .form-select-sm {
            padding: 0.25rem 2rem 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
            background-color: white;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .form-select-sm:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .form-select-sm:hover {
            border-color: var(--primary-color);
        }

        /* Add flash message styles */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: none;
            border-radius: 1rem;
            font-weight: 600;
        }

        .alert-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #10b981 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #ef4444 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="container">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.orders.index') }}" class="btn-back no-print">
                    <i class="fas fa-arrow-right"></i>
                    العودة للطلبات
                </a>
                <button onclick="window.print()" class="btn-print no-print">
                    <i class="fas fa-print"></i>
                    طباعة الطلب
                </button>
            </div>

            <div class="row">
                <!-- معلومات الطلب -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i>
                                معلومات الطلب
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>رقم الطلب:</th>
                                        <td>#{{ $order->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>تاريخ الطلب:</th>
                                        <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                    </tr>
                                    <tr>
                                        <th>حالة الطلب:</th>
                                        <td>
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="order_status" class="form-select form-select-sm d-inline-block w-auto me-2" onchange="this.form.submit()">
                                                    <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                                    <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                                    <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                    <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                                </select>
                                            </form>
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
                                    </tr>
                                    <tr>
                                        <th>طريقة الدفع:</th>
                                        <td>{{ $order->payment_method === 'cash' ? 'كاش' : 'بطاقة' }}</td>
                                    </tr>
                                    <tr>
                                        <th>حالة الدفع:</th>
                                        <td>
                                            <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="payment_status" class="form-select form-select-sm d-inline-block w-auto me-2" onchange="this.form.submit()">
                                                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>تم الدفع</option>
                                                    <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>فشل الدفع</option>
                                                </select>
                                            </form>
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
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- معلومات العميل -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user"></i>
                                معلومات العميل
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>اسم العميل:</th>
                                        <td>{{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>البريد الإلكتروني:</th>
                                        <td>{{ $order->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>رقم الهاتف:</th>
                                        <td>{{ $order->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>عنوان التوصيل:</th>
                                        <td>{{ $order->shipping_address }}</td>
                                    </tr>
                                    @if($order->notes)
                                    <tr>
                                        <th>ملاحظات:</th>
                                        <td>{{ $order->notes }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- المنتجات التي لها مواعيد -->
            @php
                $itemsWithAppointments = $order->items->filter(function($item) {
                    return $item->appointment !== null;
                });
            @endphp

            @if($itemsWithAppointments->isNotEmpty())
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt"></i>
                        المنتجات التي لها مواعيد
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($itemsWithAppointments as $item)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="info-box">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-3" style="background: linear-gradient(135deg, var(--info-color) 0%, #0ea5e9 100%);">
                                        <i class="fas fa-tshirt"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $item->product->name }}</h5>
                                        <span class="badge bg-info">
                                            {{ $item->quantity }} قطعة
                                        </span>
                                    </div>
                                </div>
                                <div class="appointment-details">
                                    <div class="mb-2">
                                        <i class="fas fa-calendar text-info"></i>
                                        <strong>تاريخ الموعد:</strong>
                                        {{ $item->appointment->appointment_date->format('Y/m/d') }}
                                    </div>
                                    <div class="mb-2">
                                        <i class="fas fa-map-marker-alt text-info"></i>
                                        <strong>الموقع:</strong>
                                        {{ $item->appointment->location === 'store' ? 'في المتجر' : 'موقع العميل' }}
                                    </div>
                                    @if($item->appointment->location === 'client_location')
                                    <div class="mb-2">
                                        <i class="fas fa-home text-info"></i>
                                        <strong>العنوان:</strong>
                                        {{ $item->appointment->address }}
                                    </div>
                                    @endif
                                    <div>
                                        <i class="fas fa-info-circle text-info"></i>
                                        <strong>الحالة:</strong>
                                        <span class="badge {{ $item->appointment->status === 'approved' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $item->appointment->status === 'approved' ? 'تم التأكيد' : 'قيد الانتظار' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- تفاصيل المنتجات -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-cart"></i>
                        تفاصيل المنتجات
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>الإجمالي</th>
                                    <th>الموعد</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price) }} ريال</td>
                                    <td>{{ number_format($item->subtotal) }} ريال</td>
                                    <td>
                                        @if($item->appointment)
                                            <span class="badge bg-info">
                                                {{ $item->appointment->appointment_date->format('Y/m/d') }}
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                {{ $item->appointment->status === 'approved' ? 'تم التأكيد' : 'قيد الانتظار' }}
                                            </small>
                                        @else
                                            <span class="badge bg-secondary">لا يوجد موعد</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">الإجمالي الكلي</th>
                                    <td colspan="2">{{ number_format($order->total_amount) }} ريال</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* إضافة ستايلات جديدة */
        .avatar {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            color: white;
            font-size: 1.25rem;
        }

        .appointment-details {
            background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
            padding: 1.25rem;
            border-radius: 1rem;
            margin-top: 1rem;
        }

        .appointment-details i {
            width: 1.5rem;
            margin-left: 0.5rem;
        }

        .appointment-details strong {
            color: var(--text-primary);
            margin-left: 0.5rem;
        }

        @media (max-width: 768px) {
            .col-md-6 {
                margin-bottom: 1rem;
            }
        }
    </style>
</body>
</html>
