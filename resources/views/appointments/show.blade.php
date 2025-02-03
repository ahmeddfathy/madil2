@extends('layouts.customer')

@section('title', 'تفاصيل الموعد')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
    .appointment-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .appointment-card {
        background: #fff;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
    }

    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .appointment-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .status-pending {
        background: rgba(var(--bs-warning-rgb), 0.1);
        color: var(--bs-warning);
    }

    .status-confirmed {
        background: rgba(var(--bs-success-rgb), 0.1);
        color: var(--bs-success);
    }

    .status-cancelled {
        background: rgba(var(--bs-danger-rgb), 0.1);
        color: var(--bs-danger);
    }

    .info-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #eee;
    }

    .info-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .section-title {
        color: #333;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-icon {
        width: 32px;
        height: 32px;
        background: rgba(var(--bs-primary-rgb), 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bs-primary);
    }

    .info-label {
        color: #666;
        font-size: 0.9rem;
    }

    .info-value {
        color: #333;
        font-weight: 500;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #eee;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -2rem;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--bs-primary);
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px var(--bs-primary);
    }

    .timeline-content {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
    }

    .timeline-date {
        font-size: 0.85rem;
        color: #666;
    }

    .timeline-text {
        margin: 0.5rem 0 0;
        color: #333;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">تفاصيل الموعد</h2>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-right"></i>
            العودة للمواعيد
        </a>
    </div>

    <div class="appointment-container">
        <div class="appointment-card">
            <div class="appointment-header">
                <h4 class="mb-0">#{{ $appointment->id }}</h4>
                <span class="appointment-status status-{{ $appointment->status }}">
                    {{ $appointment->status_text }}
                </span>
            </div>

            <div class="info-section">
                <h5 class="section-title">
                    <i class="bi bi-info-circle me-2"></i>
                    معلومات الموعد
                </h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-grid"></i>
                            </div>
                            <div>
                                <div class="info-label">نوع الخدمة</div>
                                <div class="info-value">{{ $appointment->service }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-calendar"></i>
                            </div>
                            <div>
                                <div class="info-label">تاريخ الموعد</div>
                                <div class="info-value">{{ $appointment->appointment_date->format('Y/m/d') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <div class="info-label">وقت الموعد</div>
                                <div class="info-value">{{ $appointment->appointment_time->format('h:i A') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <div class="info-label">الموقع</div>
                                <div class="info-value">{{ $appointment->location }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($appointment->notes)
            <div class="info-section">
                <h5 class="section-title">
                    <i class="bi bi-card-text me-2"></i>
                    ملاحظات
                </h5>
                <p class="mb-0">{{ $appointment->notes }}</p>
            </div>
            @endif

            <div class="info-section">
                <h5 class="section-title">
                    <i class="bi bi-clock-history me-2"></i>
                    سجل الموعد
                </h5>
                <div class="timeline">
                    @if(isset($appointment->history) && count($appointment->history) > 0)
                    @foreach($appointment->history as $history)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">{{ $history->created_at->format('Y/m/d h:i A') }}</div>
                            <p class="timeline-text">{{ $history->description }}</p>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <p class="timeline-text text-muted">لا يوجد سجل للموعد حتى الآن</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($appointment->status === 'pending')
            <div class="text-center">
                <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('هل أنت متأكد من إلغاء الموعد؟')">
                        <i class="bi bi-x-lg me-2"></i>
                        إلغاء الموعد
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
