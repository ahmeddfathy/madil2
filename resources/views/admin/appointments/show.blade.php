@extends('layouts.admin')

@section('title', 'تفاصيل الموعد')
@section('page_title', 'تفاصيل الموعد')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid px-0">
            <div class="row mx-0">
                <div class="col-12 px-0">
                    <div class="appointments-container">
                        <!-- Back Button -->
                        <div class="mb-4">
                            <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-right ml-2"></i>
                                العودة للمواعيد
                            </a>
                        </div>

                        <!-- Appointment Details -->
                        <div class="row g-4">
                            <!-- Customer Information -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">
                                            <i class="fas fa-user-circle text-primary me-2"></i>
                                            معلومات العميل
                                        </h5>
                                        <div class="customer-details">
                                            <!-- Basic Info -->
                                            <div class="detail-item mb-4">
                                                <dt><i class="fas fa-user"></i> الاسم</dt>
                                                <dd>{{ $appointment->user->name }}</dd>
                                            </div>
                                            <div class="detail-item mb-4">
                                                <dt><i class="fas fa-envelope"></i> البريد الإلكتروني</dt>
                                                <dd>{{ $appointment->user->email }}</dd>
                                            </div>

                                            <!-- Phone Numbers -->
                                            <div class="detail-section mb-4">
                                                <h6 class="section-title mb-3">
                                                    <i class="fas fa-phone-alt text-primary me-2"></i>
                                                    أرقام الهواتف
                                                </h6>
                                                @forelse($appointment->user->phoneNumbers as $phone)
                                                    <div class="phone-item mb-2 p-2 rounded {{ $phone->is_primary ? 'bg-light border' : '' }}">
                                                        <div class="d-flex align-items-center">
                                                            <span class="phone-number">
                                                                {{ $phone->phone }}
                                                            </span>
                                                            @if($phone->is_primary)
                                                                <span class="badge bg-primary ms-2">رئيسي</span>
                                                            @endif
                                                            <span class="phone-type text-muted ms-2">
                                                                ({{ $phone->type_text }})
                                                            </span>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p class="text-muted">لا توجد أرقام هواتف مسجلة</p>
                                                @endforelse
                                            </div>

                                            <!-- Addresses -->
                                            <div class="detail-section">
                                                <h6 class="section-title mb-3">
                                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                    العناوين
                                                </h6>
                                                @forelse($appointment->user->addresses as $address)
                                                    <div class="address-item mb-3 p-3 border rounded {{ $address->is_primary ? 'border-primary' : '' }}">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="address-type">
                                                                <span class="fw-bold">{{ $address->type_text }}</span>
                                                                @if($address->is_primary)
                                                                    <span class="badge bg-primary ms-2">رئيسي</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="address-details mt-2">
                                                            <p class="mb-1"><i class="fas fa-city me-2"></i>{{ $address->city }}</p>
                                                            <p class="mb-1"><i class="fas fa-map me-2"></i>{{ $address->area }}</p>
                                                            <p class="mb-1"><i class="fas fa-road me-2"></i>{{ $address->street }}</p>
                                                            @if($address->building_no)
                                                                <p class="mb-1"><i class="fas fa-building me-2"></i>مبنى {{ $address->building_no }}</p>
                                                            @endif
                                                            @if($address->details)
                                                                <p class="mb-0 text-muted"><i class="fas fa-info-circle me-2"></i>{{ $address->details }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p class="text-muted">لا توجد عناوين مسجلة</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Appointment Information -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">
                                            <i class="fas fa-calendar-check text-primary me-2"></i>
                                            معلومات الموعد
                                        </h5>
                                        <div class="appointment-details">
                                            <div class="detail-item">
                                                <dt><i class="fas fa-briefcase"></i> الخدمة</dt>
                                                <dd>{{ $appointment->service_type }}</dd>
                                            </div>
                                            <div class="detail-item">
                                                <dt><i class="fas fa-calendar"></i> التاريخ والوقت</dt>
                                                <dd>
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }}
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                                </dd>
                                            </div>
                                            <div class="detail-item">
                                                <dt><i class="fas fa-clock"></i> المدة</dt>
                                                <dd>{{ $appointment->duration ?? 'غير محدد' }}</dd>
                                            </div>
                                            <div class="detail-item">
                                                <dt><i class="fas fa-tag"></i> السعر</dt>
                                                <dd>{{ $appointment->price ? number_format($appointment->price, 2) . ' ريال' : 'غير محدد' }}</dd>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Information -->
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">
                                            <i class="fas fa-info-circle text-primary me-2"></i>
                                            حالة الموعد
                                        </h5>
                                        <div class="status-details">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="status-badge {{ $appointment->status }}">
                                                        <i class="fas fa-circle status-icon"></i>
                                                        @switch($appointment->status)
                                                            @case('pending')
                                                                قيد الانتظار
                                                                @break
                                                            @case('approved')
                                                                تم الموافقة
                                                                @break
                                                            @case('completed')
                                                                مكتمل
                                                                @break
                                                            @case('cancelled')
                                                                ملغي
                                                                @break
                                                            @default
                                                                {{ $appointment->status }}
                                                        @endswitch
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                                    @if($appointment->status == 'pending')
                                                    <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="btn btn-success me-2">
                                                            <i class="fas fa-check me-1"></i>
                                                            قبول الموعد
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times me-1"></i>
                                                            رفض الموعد
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Related Orders -->
                            @if($appointment->orderItems->isNotEmpty())
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">
                                            <i class="fas fa-shopping-cart text-primary me-2"></i>
                                            الطلبات المرتبطة
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>رقم الطلب</th>
                                                        <th>المنتج</th>
                                                        <th>السعر</th>
                                                        <th>الحالة</th>
                                                        <th>تاريخ الطلب</th>
                                                        <th>الإجراءات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($appointment->orderItems as $item)
                                                    <tr>
                                                        <td>#{{ $item->order->id }}</td>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ number_format($item->unit_price, 2) }} ريال</td>
                                                        <td>
                                                            <span class="badge bg-{{ $item->order->order_status === 'completed' ? 'success' : 'warning' }}">
                                                                {{ $item->order->order_status }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $item->order->created_at->format('Y-m-d') }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.orders.show', $item->order) }}"
                                                               class="btn btn-sm btn-light-primary">
                                                                <i class="fas fa-eye"></i>
                                                                عرض الطلب
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($appointment->notes)
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-sticky-note text-primary me-2"></i>
                            ملاحظات
                        </h5>
                        <div class="notes-text">
                            {{ $appointment->notes }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/appointments.css') }}">
@endsection
