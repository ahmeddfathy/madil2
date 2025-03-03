<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AppointmentDateTimeUpdated extends Notification
{
    use Queueable, SerializesModels;

    protected $appointment;
    private $appointmentId;
    private $appointmentDate;
    private $appointmentTime;
    private $appointmentNotes;
    private $userId;

    public function __construct(Appointment $appointment)
    {
        try {
            $this->appointment = $appointment;

            if (!$appointment->exists) {
                throw new \Exception('Appointment model does not exist');
            }

            // Set Carbon locale to Arabic
            Carbon::setLocale('ar');

            // Store essential data as primitive types
            $this->appointmentId = $appointment->id;

            if ($appointment->appointment_date) {
                $date = Carbon::parse($appointment->appointment_date);
                $this->appointmentDate = $date->translatedFormat('l j F Y'); // Will show like "الأحد 15 فبراير 2024"
            } else {
                $this->appointmentDate = 'غير محدد';
            }

            $this->appointmentTime = $appointment->appointment_time ? Carbon::parse($appointment->appointment_time)->format('H:i') : 'غير محدد';
            $this->appointmentNotes = $appointment->notes;
            $this->userId = $appointment->user_id;

            Log::info('Creating appointment date/time update notification', [
                'appointment_id' => $this->appointmentId,
                'date' => $this->appointmentDate,
                'time' => $this->appointmentTime,
                'user_id' => $this->userId,
                'user_email' => $appointment->user->email ?? 'No email found'
            ]);
        } catch (Throwable $e) {
            Log::error('Error in AppointmentDateTimeUpdated constructor', [
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
            return (new MailMessage)
                ->view('emails.notifications', [
                    'title' => '📅 تحديث موعد الزيارة',
                    'greeting' => "✨ مرحباً {$notifiable->name}",
                    'intro' => "تم تحديث موعد زيارتك إلى {$this->appointmentDate} الساعة {$this->appointmentTime}",
                    'content' => [
                        'sections' => [
                            [
                                'title' => 'تفاصيل الموعد الجديد',
                                'items' => [
                                    "🔖 رقم المرجع: {$this->appointment->reference_number}",
                                    "📅 التاريخ: {$this->appointmentDate}",
                                    "⏰ الوقت: {$this->appointmentTime}",
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
            Log::error('Error preparing appointment date/time update email', [
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
                'title' => 'تحديث موعد الزيارة',
                'message' => "تم تحديث موعد زيارتك إلى {$this->appointmentDate} الساعة {$this->appointmentTime}",
                'type' => 'appointment_datetime_updated',
                'reference_number' => $this->appointment->reference_number,
                'date' => $this->appointmentDate,
                'time' => $this->appointmentTime
            ];
        } catch (Throwable $e) {
            Log::error('Error in toArray method', [
                'error' => $e->getMessage(),
                'appointment_id' => $this->appointmentId
            ]);

            return [
                'title' => 'تحديث موعد الزيارة',
                'message' => 'حدث خطأ أثناء معالجة الإشعار',
                'type' => 'appointment_datetime_updated',
                'reference_number' => $this->appointment->reference_number
            ];
        }
    }

    public function failed(Throwable $e)
    {
        Log::error('Failed to send appointment date/time update notification', [
            'error' => $e->getMessage(),
            'error_trace' => $e->getTraceAsString(),
            'appointment_id' => $this->appointmentId ?? null,
            'appointment_data' => [
                'date' => $this->appointmentDate ?? null,
                'time' => $this->appointmentTime ?? null
            ]
        ]);
    }
}
