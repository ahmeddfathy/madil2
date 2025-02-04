@extends('layouts.customer')

@section('title', 'حجز موعد جديد')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('assets/css/customer/appointments.css') }}">
@endsection

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">حجز موعد جديد</h2>
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary">
      <i class="bi bi-arrow-right"></i>
      العودة للمواعيد
                        </a>
                    </div>

  <div class="booking-container">
    <form action="{{ route('appointments.store') }}" method="POST" class="booking-form">
      @csrf

      @if ($errors->any())
      <div class="alert alert-danger mb-4">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <div class="form-section">
        <h4 class="section-title">
          <i class="bi bi-grid me-2"></i>
          اختر نوع الخدمة
        </h4>
        <div class="row g-3">
          @foreach($services as $service)
          <div class="col-md-6">
            <div class="service-option" data-service="{{ $service->id }}">
              <div class="d-flex gap-3">
                <div class="service-icon">
                  <i class="bi {{ $service->icon }}"></i>
                </div>
                <div>
                  <h5 class="mb-1">{{ $service->name }}</h5>
                  <p class="mb-0 text-muted">{{ $service->description }}</p>
                            </div>
                        </div>
                            </div>
                        </div>
          @endforeach
                            </div>
        <input type="hidden" name="service_id" id="service_id" required>
                        </div>

      <div class="form-section">
        <h4 class="section-title">
          <i class="bi bi-calendar me-2"></i>
          اختر التاريخ والوقت
        </h4>
        <div class="row g-3">
                        <div class="col-md-6">
            <label class="form-label">التاريخ</label>
            <input type="date" name="appointment_date" class="form-control" required
              min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
            <label class="form-label">الوقت</label>
            <div class="time-slots d-flex flex-wrap gap-2">
              @foreach($timeSlots as $slot)
              <div class="time-slot" data-time="{{ $slot }}">
                {{ $slot }}
                            </div>
              @endforeach
                        </div>
            <input type="hidden" name="appointment_time" id="appointment_time" required>
                            </div>
                            </div>
                        </div>

      <div class="form-section">
        <h4 class="section-title">
          <i class="bi bi-geo-alt me-2"></i>
          معلومات إضافية
        </h4>
        <div class="row g-3">
          <div class="col-md-12">
            <label class="form-label">الموقع</label>
            <select name="location" class="form-select" required>
              <option value="">اختر الموقع</option>
              @foreach($locations as $location)
              <option value="{{ $location->id }}">{{ $location->name }}</option>
              @endforeach
            </select>
                        </div>
          <div class="col-md-12">
            <label class="form-label">ملاحظات إضافية</label>
            <textarea name="notes" class="form-control" rows="3"
              placeholder="أضف أي ملاحظات إضافية هنا..."></textarea>
            </div>
        </div>
    </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary btn-lg px-5">
          <i class="bi bi-calendar-check me-2"></i>
          تأكيد الحجز
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    // اختيار الخدمة
    document.querySelectorAll('.service-option').forEach(option => {
      option.addEventListener('click', function() {
        document.querySelectorAll('.service-option').forEach(opt => opt.classList.remove('selected'));
        this.classList.add('selected');
        document.getElementById('service_id').value = this.dataset.service;
      });
    });

    // اختيار الوقت
    document.querySelectorAll('.time-slot').forEach(slot => {
      slot.addEventListener('click', function() {
        if (this.classList.contains('disabled')) return;
        document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
        this.classList.add('selected');
        document.getElementById('appointment_time').value = this.dataset.time;
      });
    });

    // التحقق من الفورم قبل الإرسال
    document.querySelector('form').addEventListener('submit', function(e) {
      if (!document.getElementById('service_id').value) {
        e.preventDefault();
        alert('الرجاء اختيار نوع الخدمة');
      }
      if (!document.getElementById('appointment_time').value) {
        e.preventDefault();
        alert('الرجاء اختيار وقت الموعد');
      }
    });
  });
    </script>
@endsection
