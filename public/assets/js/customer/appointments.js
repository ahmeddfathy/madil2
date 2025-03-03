document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('appointmentForm');
    const dateInput = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('appointment_time');
    const submitBtn = document.getElementById('submitBtn');
    const spinner = document.querySelector('.loading-spinner');
    const errorDiv = document.getElementById('appointmentErrors');
    const dateError = document.getElementById('date-error');
    const timeError = document.getElementById('time-error');

    // تحديد المواعيد المتاحة حسب اليوم
    if (dateInput) {
        const today = new Date();
        const maxDate = new Date();
        maxDate.setDate(today.getDate() + 30);

        dateInput.min = today.toISOString().split('T')[0];
        dateInput.max = maxDate.toISOString().split('T')[0];

        // Handle date change
        dateInput.addEventListener('change', function() {
            const timeSelect = document.getElementById('appointment_time');
            const dateError = document.getElementById('date-error');

            // Reset time select and validation states
            timeSelect.innerHTML = '<option value="">اختر الوقت المناسب</option>';
            timeSelect.disabled = true;
            dateError.textContent = '';
            this.classList.remove('is-invalid');

            if (!this.value) return;

            // Show loading indicator
            const loadingIndicator = document.createElement('div');
            loadingIndicator.className = 'time-loading text-center my-2';
            loadingIndicator.innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> <span>جاري تحميل المواعيد المتاحة...</span>';
            timeSelect.parentNode.appendChild(loadingIndicator);

            // Parse the date correctly for timezone handling
            const [year, month, day] = this.value.split('-').map(Number);
            const selectedDate = new Date(year, month - 1, day); // month is 0-based in JavaScript
            const dayOfWeek = selectedDate.getDay();

            // Arabic day names
            const arabicDays = {
                0: 'الأحد',
                1: 'الإثنين',
                2: 'الثلاثاء',
                3: 'الأربعاء',
                4: 'الخميس',
                5: 'الجمعة',
                6: 'السبت'
            };

            // Fetch available time slots from API
            fetch(`/appointments/available-slots?date=${this.value}&_=${Date.now()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Cache-Control': 'no-cache, no-store',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            throw new Error(`فشل في جلب المواعيد المتاحة (${response.status})`);
                        }
                    });
                }
                return response.json();
            })
            .then(data => {
                // Remove loading indicator
                loadingIndicator.remove();

                if (data.success) {
                    // If no available slots and a suggested date is provided
                    if (data.available_slots.length === 0 && data.suggested_date) {
                        const suggestionDiv = document.createElement('div');
                        suggestionDiv.className = 'alert alert-info mt-2';
                        suggestionDiv.innerHTML = `${data.message} <button type="button" class="btn btn-sm btn-primary ms-2 select-suggested-date">اختر هذا التاريخ</button>`;

                        // Add element above the time select
                        timeSelect.parentNode.insertBefore(suggestionDiv, timeSelect);

                        // Add event listener to the suggested date button
                        suggestionDiv.querySelector('.select-suggested-date').addEventListener('click', function() {
                            dateInput.value = data.suggested_date;
                            dateInput.dispatchEvent(new Event('change'));
                            suggestionDiv.remove();
                        });

                        return;
                    }

                    // Add day name to time select
                    timeSelect.innerHTML = `<option value="">اختر الوقت المناسب ليوم ${arabicDays[dayOfWeek]}</option>`;

                    // Populate time slots
                    data.available_slots.forEach(slotGroup => {
                        const group = document.createElement('optgroup');
                        group.label = slotGroup.label;

                        slotGroup.times.forEach(time => {
                            const option = document.createElement('option');
                            option.value = time.value;
                            option.textContent = time.label;
                            group.appendChild(option);
                        });

                        timeSelect.appendChild(group);
                    });

                    // Enable time select only if there are available slots
                    const hasSlots = timeSelect.querySelectorAll('option').length > 1;
                    timeSelect.disabled = !hasSlots;

                    if (!hasSlots) {
                        dateError.textContent = 'لا توجد مواعيد متاحة في هذا اليوم، يرجى اختيار يوم آخر';
                        this.classList.add('is-invalid');
                    }
                } else {
                    throw new Error(data.message || 'فشل في جلب المواعيد المتاحة');
                }
            })
            .catch(error => {
                // Remove loading indicator
                if (loadingIndicator.parentNode) {
                    loadingIndicator.remove();
                }

                console.error('Error:', error);
                dateError.textContent = error.message;
                this.classList.add('is-invalid');
            });
        });

        // Trigger change event if date is already selected
        if (dateInput.value) {
            dateInput.dispatchEvent(new Event('change'));
        }
    }

    // معالجة تقديم النموذج
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // التحقق من الملاحظات
        const notes = document.getElementById('notes');
        if (notes.value.length < 10) {
            errorDiv.style.display = 'block';
            errorDiv.textContent = 'يرجى إضافة تفاصيل كافية للتصميم المخصص (10 أحرف على الأقل)';
            notes.focus();
            return;
        }

        // التحقق من اختيار الوقت
        if (!timeSelect.value) {
            errorDiv.style.display = 'block';
            errorDiv.textContent = 'يرجى اختيار وقت للموعد';
            timeSelect.focus();
            return;
        }

        // إظهار حالة التحميل
        submitBtn.disabled = true;
        spinner.style.display = 'inline-block';
        errorDiv.style.display = 'none';
        errorDiv.textContent = '';

        // تجميع بيانات النموذج
        const formData = new FormData(form);

        // إرسال الطلب
        fetch(form.getAttribute('data-url'), {
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
                // إظهار رسالة النجاح
                const notification = document.createElement('div');
                notification.className = 'alert alert-success';
                notification.textContent = data.message;
                form.insertBefore(notification, form.firstChild);

                // إعادة التوجيه بعد تأخير
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

            // إعادة تحميل المواعيد المتاحة في حالة حدوث خطأ مثل "الموعد محجوز بالفعل"
            if (error.message.includes('محجوز بالفعل')) {
                // تحديث المواعيد المتاحة
                dateInput.dispatchEvent(new Event('change'));
            }
        })
        .finally(() => {
            // إعادة تعيين حالة التحميل
            submitBtn.disabled = false;
            spinner.style.display = 'none';
        });
    });

    // معالجة زر الإلغاء
    document.getElementById('cancelBtn')?.addEventListener('click', function() {
        if (confirm('هل أنت متأكد من إلغاء حجز الموعد؟')) {
            window.location.href = '/appointments'; // العودة لصفحة المواعيد
        }
    });
});
