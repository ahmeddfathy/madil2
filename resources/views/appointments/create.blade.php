@extends('layouts.customer')

@section('title', 'حجز موعد تصميم مخصص')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('assets/css/customer/appointments.css') }}">
<style>
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
        border: 2px solid #6c5ce7;
    }

    .section-title {
        color: #333;
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #555;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        padding: 0.75rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #6c5ce7;
        box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.1);
    }

    .btn-submit {
        background: #6c5ce7;
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: #5849c2;
        transform: translateY(-2px);
    }

    .error-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .design-info {
        background: #f8f9fe;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    #appointmentErrors {
        display: none;
        margin-bottom: 1rem;
    }

    .loading-spinner {
        display: none;
        margin-right: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">حجز موعد تصميم مخصص</h2>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-right"></i>
            العودة للمواعيد
        </a>
    </div>

    <div class="alert alert-danger" id="appointmentErrors"></div>

    <form id="appointmentForm" class="appointment-form">
        @csrf
        <input type="hidden" name="service_type" value="custom_design">

        <div class="design-info">
            <h5 class="mb-3">
                <i class="bi bi-info-circle me-2"></i>
                معلومات عن التصميم المخصص
            </h5>
            <p>نقدم لكِ خدمة تصميم العبايات حسب رغبتك وذوقك الخاص. يرجى تقديم أكبر قدر من التفاصيل لمساعدتنا في فهم متطلباتك بشكل أفضل.</p>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-calendar-fill"></i>
                موعد الزيارة
            </h3>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label" for="appointment_date">التاريخ</label>
                        <input type="date" class="form-control" id="appointment_date" name="appointment_date"
                               min="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label" for="appointment_time">الوقت</label>
                        <input type="time" class="form-control" id="appointment_time" name="appointment_time"
                               min="09:00" max="21:00" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-brush"></i>
                تفاصيل التصميم
            </h3>
            <div class="mb-4">
                <label class="form-label" for="notes">وصف التصميم المطلوب</label>
                <textarea class="form-control" id="notes" name="notes" rows="6"
                          placeholder="يرجى وصف التصميم المطلوب بالتفصيل (الألوان، القصة، التطريز، الأكمام، إلخ...)" required minlength="10"></textarea>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-geo-alt-fill"></i>
                مكان المقابلة
            </h3>
            <div class="mb-4">
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="location" id="location_store"
                               value="store" checked>
                        <label class="form-check-label" for="location_store">
                            في المحل
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="location" id="location_client"
                               value="client_location">
                        <label class="form-check-label" for="location_client">
                            في موقع العميل
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4 d-none" id="addressField">
                <label class="form-label" for="address">العنوان</label>
                <textarea class="form-control" id="address" name="address" rows="3"
                          placeholder="يرجى إدخال العنوان بالتفصيل"></textarea>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-person-fill"></i>
                معلومات التواصل
            </h3>
            <div class="mb-4">
                <label class="form-label" for="phone">رقم الهاتف</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                       value="{{ Auth::user()->phone ?? '' }}" required>
            </div>
        </div>

        <div class="d-grid gap-2 col-md-6 mx-auto mt-4">
            <button type="submit" class="btn btn-submit" id="submitBtn">
                <span class="loading-spinner spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <i class="bi bi-calendar-check me-2"></i>
                تأكيد حجز الموعد
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const locationStore = document.getElementById('location_store');
    const locationClient = document.getElementById('location_client');
    const addressField = document.getElementById('addressField');
    const form = document.getElementById('appointmentForm');
    const submitBtn = document.getElementById('submitBtn');
    const spinner = document.querySelector('.loading-spinner');
    const errorDiv = document.getElementById('appointmentErrors');

    // Handle location change
    function toggleAddress() {
        if (locationClient.checked) {
            addressField.classList.remove('d-none');
            document.getElementById('address').setAttribute('required', 'required');
        } else {
            addressField.classList.add('d-none');
            document.getElementById('address').removeAttribute('required');
            document.getElementById('address').value = '';
        }
    }

    locationStore.addEventListener('change', toggleAddress);
    locationClient.addEventListener('change', toggleAddress);

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const notes = document.getElementById('notes');
        if (notes.value.length < 10) {
            errorDiv.style.display = 'block';
            errorDiv.textContent = 'يرجى إضافة تفاصيل كافية للتصميم المخصص (10 أحرف على الأقل)';
            notes.focus();
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        spinner.style.display = 'inline-block';
        errorDiv.style.display = 'none';
        errorDiv.textContent = '';

        // Prepare form data
        const formData = new FormData(form);

        // Send request
        fetch('{{ route('appointments.store') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'حدث خطأ أثناء حجز الموعد');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message
                const notification = document.createElement('div');
                notification.className = 'alert alert-success';
                notification.textContent = data.message;
                form.insertBefore(notification, form.firstChild);

                // Redirect after delay
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 2000);
            } else {
                throw new Error(data.message || 'حدث خطأ أثناء حجز الموعد');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorDiv.style.display = 'block';
            errorDiv.textContent = error.message;
            if (error.errors) {
                const errorList = document.createElement('ul');
                Object.values(error.errors).forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error[0];
                    errorList.appendChild(li);
                });
                errorDiv.appendChild(errorList);
            }
        })
        .finally(() => {
            // Reset loading state
            submitBtn.disabled = false;
            spinner.style.display = 'none';
        });
    });
});
</script>
@endsection
