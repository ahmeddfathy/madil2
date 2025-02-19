<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;

        // تسجيل بيانات الطلب عند إنشاء الإشعار
        Log::info('Creating order status notification', [
            'order_id' => $order->id,
            'order_status' => $order->order_status,
            'user_id' => $order->user_id,
            'user_email' => $order->user->email ?? 'No email found'
        ]);
    }

    public function via($notifiable): array
    {
        // تسجيل معلومات المستخدم المراد إرسال الإشعار له
        Log::info('Notification channels for user', [
            'user_id' => $notifiable->id,
            'user_email' => $notifiable->email,
            'channels' => ['mail', 'database']
        ]);

        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        try {
            // تسجيل محاولة إرسال البريد
            Log::info('Attempting to send email notification', [
                'to_email' => $notifiable->email,
                'user_name' => $notifiable->name,
                'order_id' => $this->order->id
            ]);

            $status = match($this->order->order_status) {
                'pending' => 'قيد الانتظار',
                'processing' => 'قيد المعالجة',
                'out_for_delivery' => 'جاري التوصيل',
                'on_the_way' => 'في الطريق',
                'delivered' => 'تم التوصيل',
                'completed' => 'مكتمل',
                'returned' => 'مرتجع',
                'cancelled' => 'ملغي',
                default => $this->order->order_status
            };

            $message = match($this->order->order_status) {
                'out_for_delivery' => 'طلبك في طريقه للتوصيل',
                'on_the_way' => 'المندوب في طريقه إليك',
                'delivered' => 'تم توصيل طلبك بنجاح',
                'returned' => 'تم إرجاع طلبك',
                default => "تم تحديث حالة طلبك إلى {$status}"
            };

            Log::info('Preparing order status email', [
                'order_id' => $this->order->id,
                'status' => $status,
                'user' => $notifiable->toArray()
            ]);

            $url = route('orders.show', $this->order->uuid);

            return (new MailMessage)
                ->subject("تحديث حالة الطلب: {$status}")
                ->greeting("مرحباً {$notifiable->name}!")
                ->line($message)
                ->line("رقم الطلب: #{$this->order->order_number}")
                ->when($this->order->notes, function ($mail) {
                    return $mail->line("ملاحظات: {$this->order->notes}");
                })
                ->action('عرض الطلب', $url)
                ->line('شكراً لتسوقك معنا!');
        } catch (\Exception $e) {
            Log::error('Error preparing order status email', [
                'error' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'order_id' => $this->order->id ?? null,
                'user_id' => $notifiable->id ?? null,
                'user_email' => $notifiable->email ?? null
            ]);
            throw $e;
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        $status = match($this->order->order_status) {
            'pending' => 'قيد الانتظار',
            'processing' => 'قيد المعالجة',
            'out_for_delivery' => 'جاري التوصيل',
            'on_the_way' => 'في الطريق',
            'delivered' => 'تم التوصيل',
            'completed' => 'مكتمل',
            'returned' => 'مرتجع',
            'cancelled' => 'ملغي',
            default => $this->order->order_status
        };

        $message = match($this->order->order_status) {
            'out_for_delivery' => 'طلبك في طريقه للتوصيل',
            'on_the_way' => 'المندوب في طريقه إليك',
            'delivered' => 'تم توصيل طلبك بنجاح',
            'returned' => 'تم إرجاع طلبك',
            default => "تم تحديث حالة الطلب إلى {$status}"
        };

        return [
            'title' => 'تحديث حالة الطلب',
            'message' => $message,
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->order->order_status,
            'status_text' => $status,
            'created_at' => now()->toDateTimeString()
        ];
    }

    /**
     * Handle a notification failure.
     */
    public function failed(\Exception $e)
    {
        Log::error('Failed to send order status notification', [
            'error' => $e->getMessage(),
            'error_trace' => $e->getTraceAsString(),
            'order_id' => $this->order->id ?? null,
            'user_email' => $this->order->user->email ?? null
        ]);
    }
}
