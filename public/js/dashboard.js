// Phone Numbers Functions
$(document).ready(function() {
    $('#addPhoneForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post('/phones', formData)
            .done(function(response) {
                $('#addPhoneModal').modal('hide');
                location.reload();
            })
            .fail(function(xhr) {
                alert(xhr.responseJSON?.message || 'حدث خطأ أثناء إضافة رقم الهاتف');
            });
    });

    // Delete Phone
    $('.delete-phone').on('click', function() {
        if (confirm('هل أنت متأكد من حذف رقم الهاتف؟')) {
            const id = $(this).data('id');
            $.ajax({
                url: `/phones/${id}`,
                type: 'DELETE',
                success: function() {
                    location.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'حدث خطأ أثناء حذف رقم الهاتف');
                }
            });
        }
    });

    // Make Phone Primary
    $('.make-primary-phone').on('click', function() {
        const id = $(this).data('id');
        $.post(`/phones/${id}/make-primary`)
            .done(function() {
                location.reload();
            })
            .fail(function(xhr) {
                alert(xhr.responseJSON?.message || 'حدث خطأ أثناء تعيين الرقم كرقم رئيسي');
            });
    });

    // Make Address Primary
    $('.make-primary-address').on('click', function() {
        const id = $(this).data('id');
        $.post(`/addresses/${id}/make-primary`)
            .done(function() {
                location.reload();
            })
            .fail(function(xhr) {
                alert(xhr.responseJSON?.message || 'حدث خطأ أثناء تعيين العنوان كعنوان رئيسي');
            });
    });

    // Reset Forms After Modal Close
    $('#addPhoneModal, #editPhoneModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
    });

    $('#addAddressModal, #editAddressModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
    });

    // Mark Notifications as Read
    $('.notification-dropdown .dropdown-item').on('click', function() {
        const notificationId = $(this).data('id');
        if (!notificationId) return;

        $.post(`/notifications/${notificationId}/read`)
            .done(function() {
                // تحديث عدد الإشعارات غير المقروءة
                const unreadCount = parseInt($('.notifications .card-info h3').text()) - 1;
                $('.notifications .card-info h3').text(unreadCount);

                // إزالة تنسيق "غير مقروء"
                $(this).removeClass('unread');

                // إزالة البادج إذا لم يعد هناك إشعارات غير مقروءة
                if (unreadCount <= 0) {
                    $('.notifications .badge').remove();
                } else {
                    $('.notifications .badge').text(unreadCount);
                }
            })
            .fail(function() {
                console.error('فشل في تحديث حالة الإشعار');
            });
    });

    // Form Validation
    function validatePhoneForm(form) {
        const phone = form.find('input[name="phone"]').val();
        if (!/^\d{10}$/.test(phone)) {
            alert('رقم الهاتف يجب أن يتكون من 10 أرقام');
            return false;
        }
        return true;
    }

    $('#addPhoneForm, #editPhoneForm').on('submit', function(e) {
        if (!validatePhoneForm($(this))) {
            e.preventDefault();
        }
    });

    // تحميل بيانات العنوان للتعديل
    $('.edit-address').on('click', function() {
        const id = $(this).data('id');

        $.get(`/addresses/${id}`)
            .done(function(address) {
                const form = $('#editAddressForm');
                form.find('select[name="type"]').val(address.type);
                form.find('input[name="city"]').val(address.city);
                form.find('input[name="area"]').val(address.area);
                form.find('input[name="street"]').val(address.street);
                form.find('input[name="building_no"]').val(address.building_no);
                form.find('textarea[name="details"]').val(address.details);
                form.find('input[name="address_id"]').val(address.id);
            })
            .fail(function() {
                alert('حدث خطأ أثناء تحميل بيانات العنوان');
            });
    });

    // تعديل العنوان
    $('#editAddressForm').on('submit', function(e) {
        e.preventDefault();
        const id = $(this).find('input[name="address_id"]').val();
        const formData = $(this).serialize();

        $.ajax({
            url: `/addresses/${id}`,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#editAddressModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'حدث خطأ أثناء تعديل العنوان');
            }
        });
    });

    // إضافة عنوان
    $('#addAddressForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post('/addresses', formData)
            .done(function(response) {
                $('#addAddressModal').modal('hide');
                location.reload();
            })
            .fail(function(xhr) {
                alert(xhr.responseJSON?.message || 'حدث خطأ أثناء إضافة العنوان');
            });
    });

    // حذف العنوان
    $('.delete-address').on('click', function() {
        if (!confirm('هل أنت متأكد من حذف هذا العنوان؟')) return;

        const id = $(this).data('id');
        $.ajax({
            url: `/addresses/${id}`,
            type: 'DELETE',
            success: function() {
                location.reload();
            },
            error: function() {
                alert('حدث خطأ أثناء حذف العنوان');
            }
        });
    });

    // التحقق من صحة نموذج العنوان
    function validateAddressForm(form) {
        const required = ['city', 'area', 'street'];
        for (const field of required) {
            const value = form.find(`[name="${field}"]`).val();
            if (!value || !value.trim()) {
                alert(`الرجاء إدخال ${field === 'city' ? 'المدينة' : field === 'area' ? 'المنطقة' : 'الشارع'}`);
                return false;
            }
        }
        return true;
    }

    $('#addAddressForm, #editAddressForm').on('submit', function(e) {
        if (!validateAddressForm($(this))) {
            e.preventDefault();
        }
    });
});
