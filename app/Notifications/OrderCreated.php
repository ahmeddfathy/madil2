<?php

namespace App\Notifications;

use App\Models\Order;
use App\Services\FirebaseNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;

class OrderCreated extends Notification
{
  use Queueable;

  protected $order;

  public function __construct(Order $order)
  {
    $this->order = $order;

    try {
      $firebaseService = App::make(FirebaseNotificationService::class);

      $title = "طلب جديد #{$order->order_number}";
      $body = "تم إنشاء طلب جديد بقيمة " . number_format($order->total_amount, 2) . " ريال";
      $link = "/admin/orders/{$order->id}";

      $itemsWithAppointments = $order->items->filter(function($item) {
        return $item->appointment !== null;
      });

      if ($itemsWithAppointments->isNotEmpty()) {
        $body .= "\n\nمواعيد المقاسات:";
        foreach ($itemsWithAppointments as $item) {
          $body .= "\nالمنتج: {$item->product->name}";
          $body .= "\nالموعد: " . $item->appointment->appointment_date->format('Y-m-d H:i');
          $body .= "\nرقم المرجع: " . $item->appointment->reference_number;
        }
      }

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
    return ['mail', 'database'];
  }

  public function toMail($notifiable): MailMessage
  {
    $this->order->load(['items.product', 'items.appointment']);

    $orderItems = $this->order->items->map(function($item) {
        return [
            "• {$item->product->name}",
            "  الكمية: {$item->quantity}",
            "  السعر: " . number_format($item->subtotal, 2) . " ريال",
            $item->appointment ? "  موعد المقاسات: " . $item->appointment->appointment_date->format('Y-m-d H:i') : null,
            $item->appointment ? "  رقم المرجع: " . $item->appointment->reference_number : null
        ];
    })->flatten()->filter()->toArray();

    return (new MailMessage)
        ->view('emails.notifications', [
            'title' => '🛍️ تأكيد الطلب #' . $this->order->order_number,
            'greeting' => "✨ مرحباً {$notifiable->name}",
            'intro' => 'نشكرك على ثقتك! تم استلام طلبك بنجاح.',
            'content' => [
                'sections' => [
                    [
                        'title' => '🛒 تفاصيل المنتجات',
                        'items' => $orderItems
                    ],
                    [
                        'title' => '📍 معلومات التوصيل',
                        'items' => [
                            "العنوان: {$this->order->shipping_address}",
                            "رقم الهاتف: {$this->order->phone}"
                        ]
                    ],
                    [
                        'title' => '💳 معلومات الدفع',
                        'items' => [
                            'طريقة الدفع: ' . ($this->order->payment_method === 'card' ? '💳 بطاقة ائتمان' : '💵 نقداً عند الاستلام'),
                            'إجمالي الطلب: 💰 ' . number_format($this->order->total_amount, 2) . ' ريال'
                        ]
                    ]
                ],
                'action' => [
                    'text' => '👉 متابعة الطلب',
                    'url' => route('orders.show', $this->order)
                ],
                'outro' => [
                    '🙏 شكراً لتسوقك معنا!',
                    '📞 إذا كان لديك أي استفسارات، لا تتردد في الاتصال بنا.'
                ]
            ]
        ]);
  }

  public function toArray($notifiable): array
  {
    $data = [
      'title' => 'تأكيد الطلب',
      'message' => 'تم استلام طلبك رقم #' . $this->order->order_number . ' بنجاح',
      'type' => 'order_created',
      'order_number' => $this->order->order_number,
      'total_amount' => $this->order->total_amount,
      'payment_method' => $this->order->payment_method
    ];

    $appointments = $this->order->items
      ->filter(function($item) {
        return $item->appointment !== null;
      })
      ->map(function($item) {
        return [
          'product_name' => $item->product->name,
          'date' => $item->appointment->appointment_date->format('Y-m-d H:i'),
          'reference_number' => $item->appointment->reference_number
        ];
      });

    if ($appointments->isNotEmpty()) {
      $data['appointments'] = $appointments->values()->all();
    }

    return $data;
  }
}
