<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Services\FirebaseNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;

class AppointmentCreated extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        if ($appointment->service_type !== 'custom_design') {
            return;
        }

        $this->appointment = $appointment;

        try {
            $firebaseService = App::make(FirebaseNotificationService::class);

            $title = "موعد جديد #{$appointment->reference_number}";
            $body = "تم حجز موعد جديد لخدمة " . $this->getServiceTypeText($appointment->service_type);
            $body .= "\nالتاريخ: " . $appointment->appointment_date->format('Y-m-d');
            $body .= "\nالوقت: " . $appointment->appointment_time;
            $body .= "\nالموقع: " . ($appointment->location === 'store' ? 'المتجر' : 'موقع العميل');

            if ($appointment->cart_item_id) {
                $body .= "\nمنتج: " . $appointment->cartItem->product->name;
            }

            $link = "/admin/appointments/{$appointment->id}";

            $result = $firebaseService->sendNotificationToAdmins(
                $title,
                $body,
                $link,
                ['link' => $link]
            );
        } catch (\Exception $e) {
        }
    }

    public function via($notifiable): array
    {
        if ($this->appointment->service_type !== 'custom_design') {
            return [];
        }

        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->view('emails.notifications', [
                'title' => '📅 تأكيد الموعد #' . $this->appointment->reference_number,
                'greeting' => "✨ مرحباً {$notifiable->name}",
                'intro' => 'شكراً لك! تم تأكيد موعدك بنجاح.',
                'content' => [
                    'sections' => [
                        [
                            'title' => 'تفاصيل الموعد',
                            'items' => [
                                "🔖 رقم المرجع: #{$this->appointment->reference_number}",
                                "نوع الخدمة: " . $this->getServiceTypeText($this->appointment->service_type),
                                "التاريخ: " . $this->appointment->appointment_date->format('Y-m-d'),
                                "الوقت: " . $this->appointment->appointment_time,
                                "الموقع: " . ($this->appointment->location === 'store' ? '🏪 المتجر' : '📍 موقع العميل'),
                                $this->appointment->address ? "العنوان: " . $this->appointment->address : null,
                                "رقم الهاتف: " . $this->appointment->phone,
                                $this->appointment->notes ? "ملاحظات: " . $this->appointment->notes : null,
                                $this->appointment->cart_item_id ? "المنتج: " . $this->appointment->cartItem->product->name : null
                            ]
                        ]
                    ],
                    'action' => [
                        'text' => '👉 تفاصيل الموعد',
                        'url' => route('appointments.show', $this->appointment->reference_number)
                    ],
                    'outro' => [
                        '🙏 شكراً لاختيارك خدماتنا!',
                        '📞 إذا كان لديك أي استفسارات، لا تتردد في الاتصال بنا.'
                    ]
                ]
            ]);
    }

    public function toArray($notifiable): array
    {
        $data = [
            'title' => 'تأكيد الموعد',
            'message' => 'تم تأكيد موعدك رقم #' . $this->appointment->reference_number,
            'type' => 'appointment_created',
            'reference_number' => $this->appointment->reference_number,
            'service_type' => $this->appointment->service_type,
            'appointment_date' => $this->appointment->appointment_date->format('Y-m-d'),
            'appointment_time' => $this->appointment->appointment_time,
            'location' => $this->appointment->location,
            'status' => $this->appointment->status
        ];

        if ($this->appointment->address) {
            $data['address'] = $this->appointment->address;
        }

        if ($this->appointment->cart_item_id) {
            $data['product'] = [
                'name' => $this->appointment->cartItem->product->name,
                'id' => $this->appointment->cartItem->product->id
            ];
        }

        return $data;
    }

    private function getServiceTypeText($type): string
    {
        return match($type) {
            'new_abaya' => 'مقاس عباية جديدة',
            'alteration' => 'تعديل مقاس',
            'repair' => 'إصلاح',
            'custom_design' => 'تصميم خاص',
            default => $type
        };
    }
}
