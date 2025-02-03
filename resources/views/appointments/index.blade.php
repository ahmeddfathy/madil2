@extends('layouts.customer')

@section('title', 'المواعيد')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
  .appointments-container {
    max-width: 1000px;
    margin: 0 auto;
  }

  .appointment-item {
    background: #fff;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    border: 1px solid #eee;
  }

  .appointment-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .appointment-icon {
    width: 48px;
    height: 48px;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bs-primary);
    font-size: 1.25rem;
  }

  .appointment-title {
    color: #333;
    font-weight: 500;
    margin-bottom: 0.5rem;
  }

  .appointment-meta {
    font-size: 0.9rem;
    color: #666;
  }

  .appointment-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
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

  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
  }

  .empty-state-icon {
    font-size: 3rem;
    color: #ccc;
    margin-bottom: 1rem;
  }

  .empty-state h3 {
    color: #333;
    margin-bottom: 0.5rem;
  }

  .empty-state p {
    color: #666;
    margin-bottom: 1.5rem;
  }

  .filters {
    margin-bottom: 2rem;
  }

  .filter-btn {
    border: none;
    background: none;
    padding: 0.5rem 1rem;
    color: #666;
    border-radius: 20px;
    transition: all 0.3s ease;
  }

  .filter-btn:hover {
    color: var(--bs-primary);
    background: rgba(var(--bs-primary-rgb), 0.1);
  }

  .filter-btn.active {
    color: #fff;
    background: var(--bs-primary);
  }
</style>
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
      <div class="d-flex gap-3">
        <div class="appointment-icon">
          <i class="bi bi-calendar-check"></i>
        </div>
        <div class="flex-grow-1">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h5 class="appointment-title">{{ $appointment->service }}</h5>
              <div class="appointment-meta">
                <div class="mb-1">
                  <i class="bi bi-clock me-1"></i>
                  {{ $appointment->appointment_date->format('Y/m/d') }}
                  {{ $appointment->appointment_time->format('h:i A') }}
                </div>
                @if($appointment->notes)
                <div class="mb-1">
                  <i class="bi bi-card-text me-1"></i>
                  {{ $appointment->notes }}
            </div>
                @endif
                            </div>
                        </div>
            <span class="appointment-status status-{{ $appointment->status }}">
                                    {{ $appointment->status_text }}
                                </span>
                            </div>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="appointment-meta">
              <i class="bi bi-geo-alt me-1"></i>
              {{ $appointment->location }}
                        </div>
            <div class="d-flex gap-2">
              @if($appointment->status === 'pending')
              <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"
                  onclick="return confirm('هل أنت متأكد من إلغاء الموعد؟')">
                  <i class="bi bi-x-lg"></i>
                  إلغاء الموعد
                                    </button>
              </form>
                                @endif
              <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-eye"></i>
                عرض التفاصيل
              </a>
            </div>
          </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
      <div class="empty-state-icon">
        <i class="bi bi-calendar-x"></i>
      </div>
      <h3>لا توجد مواعيد</h3>
      <p>لم تقم بحجز أي مواعيد بعد</p>
      <a href="{{ route('appointments.create') }}" class="btn btn-primary">
        حجز موعد جديد
                        </a>
                    </div>
                @endforelse

    <div class="mt-4">
                    {{ $appointments->links() }}
                </div>
        </div>
    </div>
@endsection
