<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AppointmentConfirmed extends Notification
{
    use Queueable, SerializesModels;

    protected $appointment;
    private $appointmentId;
    private $appointmentDate;
    private $appointmentTime;
    private $serviceType;
    private $userId;

    public function __construct(Appointment $appointment)
    {
        try {
            // التحقق من نوع الخدمة أولاً
            if ($appointment->service_type !== 'custom_design') {
                return;
            }

            $this->appointment = $appointment;

            if (!$appointment->exists) {
                throw new \Exception('Appointment model does not exist');
            }

            // Store essential data as primitive types
            $this->appointmentId = $appointment->id;
            $this->appointmentDate = $appointment->date instanceof Carbon ? $appointment->date->format('Y-m-d') : null;
            $this->appointmentTime = $appointment->time;
            $this->serviceType = $appointment->service_type;
            $this->userId = $appointment->user_id;

            Log::info('Creating appointment confirmation notification', [
                'appointment_id' => $this->appointmentId,
                'date' => $this->appointmentDate,
                'time' => $this->appointmentTime,
                'service' => $this->serviceType,
                'user_id' => $this->userId,
                'user_email' => $appointment->user->email ?? 'No email found'
            ]);
        } catch (Throwable $e) {
            Log::error('Error in AppointmentConfirmed constructor', [
                'error' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'appointment_id' => $appointment->id ?? null
            ]);
            throw $e;
        }
    }

    public function via($notifiable): array
    {
        try {
            // التحقق من نوع الخدمة
            if ($this->serviceType !== 'custom_design') {
                return [];
            }

            $channels = ['database'];

            if ($notifiable && $notifiable->email) {
                $channels[] = 'mail';
            }

            Log::info('Notification channels for user', [
                'user_id' => $notifiable->id ?? null,
                'user_email' => $notifiable->email ?? null,
                'channels' => $channels
            ]);

            return $channels;
        } catch (Throwable $e) {
            Log::error('Error in via method', [
                'error' => $e->getMessage(),
                'notifiable_id' => $notifiable->id ?? null
            ]);
            return ['database']; // Fallback to database only
        }
    }

    public function toMail($notifiable): MailMessage
    {
        try {
            $serviceTypes = [
                'new_abaya' => '👗 عباية جديدة',
                'alteration' => '✂️ تعديل',
                'repair' => '🧵 إصلاح',
                'custom_design' => '✨ تصميم خاص'
            ];

            $serviceText = $serviceTypes[$this->serviceType] ?? ucfirst($this->serviceType);

            return (new MailMessage)
                ->view('emails.notifications', [
                    'title' => 'تأكيد الموعد - ' . $this->appointment->reference_number,
                    'greeting' => "✨ مرحباً {$notifiable->name}!",
                    'intro' => 'تم تأكيد موعدك بنجاح!',
                    'content' => [
                        'sections' => [
                            [
                                'title' => 'تفاصيل الموعد',
                                'items' => [
                                    "🔖 رقم المرجع: {$this->appointment->reference_number}",
                                    "📅 التاريخ: {$this->appointmentDate}",
                                    "⏰ الوقت: {$this->appointmentTime}",
                                    "💫 الخدمة: {$serviceText}",
                                ]
                            ],
                            [
                                'title' => 'معلومات الموقع',
                                'items' => [
                                    "📍 الموقع: {$this->appointment->location_text}",
                                    $this->appointment->address ? "العنوان: {$this->appointment->address}" : null,
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
        } catch (Throwable $e) {
            Log::error('Error preparing appointment confirmation email', [
                'error' => $e->getMessage(),
                'appointment_reference' => $this->appointment->reference_number
            ]);
            throw $e;
        }
    }

    public function toArray($notifiable): array
    {
        try {
            return [
                'title' => 'تأكيد الموعد',
                'message' => "تم تأكيد موعدك بتاريخ {$this->appointmentDate} الساعة {$this->appointmentTime}",
                'type' => 'appointment_confirmed',
                'reference_number' => $this->appointment->reference_number
            ];
        } catch (Throwable $e) {
            Log::error('Error in toArray method', [
                'error' => $e->getMessage(),
                'appointment_id' => $this->appointmentId
            ]);

            return [
                'title' => 'تأكيد الموعد',
                'message' => 'حدث خطأ أثناء معالجة الإشعار',
                'type' => 'appointment_confirmed',
                'appointment_id' => $this->appointmentId
            ];
        }
    }

    public function failed(Throwable $e)
    {
        Log::error('Failed to send appointment confirmation notification', [
            'error' => $e->getMessage(),
            'error_trace' => $e->getTraceAsString(),
            'appointment_id' => $this->appointmentId ?? null,
            'appointment_data' => [
                'date' => $this->appointmentDate ?? null,
                'time' => $this->appointmentTime ?? null,
                'service' => $this->serviceType ?? null
            ]
        ]);
    }
}
