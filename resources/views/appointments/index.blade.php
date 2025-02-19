@extends('layouts.customer')

@section('title', 'المواعيد')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('assets/css/customer/appointments.css') }}">
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">المواعيد</h2>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            حجز موعد جديد
        </a>
    </div>

    <div class="filters">
        <div class="d-flex justify-content-center flex-wrap">
            <a href="{{ route('appointments.index') }}"
               class="filter-btn {{ request('filter') === null ? 'active' : '' }}">
                الكل
            </a>
            <a href="{{ route('appointments.index', ['filter' => 'upcoming']) }}"
               class="filter-btn {{ request('filter') === 'upcoming' ? 'active' : '' }}">
                المواعيد القادمة
            </a>
            <a href="{{ route('appointments.index', ['filter' => 'past']) }}"
               class="filter-btn {{ request('filter') === 'past' ? 'active' : '' }}">
                المواعيد السابقة
            </a>
        </div>
    </div>

    <div class="appointments-container">
        @forelse($appointments as $appointment)
            <div class="appointment-item">
                <div class="appointment-header">
                    <div class="d-flex align-items-start gap-3">
                        <div class="appointment-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h5 class="appointment-title">
                            @if($appointment->service_type === 'custom_design')
                                <span class="badge bg-primary">
                                    <i class="bi bi-brush me-1"></i>
                                    تصميم مخصص
                                </span>
                            @else
                                {{ $appointment->service }}
                            @endif
                        </h5>
                    </div>
                    <div class="appointment-status status-{{ $appointment->status }}">
                        {{ $appointment->status_text }}
                    </div>
                </div>

                <div class="appointment-meta">
                    <div class="meta-item">
                        <i class="bi bi-hash"></i>
                        <strong class="meta-label">رقم المرجع:</strong>
                        <span>{{ $appointment->reference_number }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-clock"></i>
                        <strong class="meta-label">الموعد:</strong>
                        <span>
                            {{ $appointment->appointment_date->format('Y/m/d') }}
                            {{ $appointment->appointment_time->format('h:i A') }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-geo-alt"></i>
                        <strong class="meta-label">المكان:</strong>
                        <span>{{ $appointment->location === 'store' ? 'المتجر' : 'موقع العميل' }}</span>
                    </div>
                    @if($appointment->notes)
                        <div class="meta-item">
                            <i class="bi bi-card-text"></i>
                            <strong class="meta-label">ملاحظات:</strong>
                            <span>{{ $appointment->notes }}</span>
                        </div>
                    @endif
                </div>

                <div class="appointment-actions">
                    <a href="{{ route('appointments.show', $appointment->reference_number) }}"
                       class="btn btn-primary">
                        <i class="bi bi-eye"></i>
                        عرض التفاصيل
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-calendar-x"></i>
                </div>
                <h3>لا توجد مواعيد</h3>
                <p>لا توجد مواعيد مسجلة حالياً</p>
                <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    حجز موعد جديد
                </a>
            </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            @if ($appointments->hasPages())
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($appointments->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $appointments->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($appointments->render()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="page-item disabled">
                                    <span class="page-link">{{ $element }}</span>
                                </li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $appointments->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($appointments->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $appointments->nextPageUrl() }}" rel="next">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>
@endsection
