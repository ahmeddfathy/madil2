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
  </div>

  <div class="filters d-flex justify-content-center gap-2">
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

  <div class="appointments-container">
    @forelse($appointments as $appointment)
    <div class="appointment-item">
      <div class="appointment-content">
        <div class="appointment-header">
          <div class="appointment-icon">
            <i class="bi bi-calendar-check"></i>
          </div>
          <h5 class="appointment-title">{{ $appointment->service }}</h5>
        </div>

        <div class="appointment-meta">
          <div class="meta-item">
            <i class="bi bi-clock"></i>
            <span>{{ $appointment->appointment_date->format('Y/m/d') }}
            {{ $appointment->appointment_time->format('h:i A') }}</span>
          </div>
          <div class="meta-item">
            <i class="bi bi-geo-alt"></i>
            <span>{{ $appointment->location }}</span>
          </div>
          @if($appointment->notes)
          <div class="meta-item">
            <i class="bi bi-card-text"></i>
            <span>{{ $appointment->notes }}</span>
          </div>
          @endif
        </div>
      </div>

      <div class="appointment-status status-{{ $appointment->status }}">
        {{ $appointment->status_text }}
      </div>

      <div class="btn-details">
        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-primary">
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
    </div>
    @endforelse

    <div class="mt-4">
      {{ $appointments->links() }}
    </div>
  </div>
</div>
@endsection
