<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderCreated extends Notification
{
  use Queueable;

  protected $order;

  public function __construct(Order $order)
  {
    $this->order = $order;
  }

  public function via($notifiable): array
  {
    return ['mail', 'database'];
  }

  public function toMail($notifiable): MailMessage
  {
    return (new MailMessage)
      ->subject('Order Confirmation')
      ->line('Thank you for your order!')
      ->line('Order #: ' . $this->order->id)
      ->line('Total: $' . number_format($this->order->total_amount, 2))
      ->action('View Order', route('orders.show', $this->order))
      ->line('Thank you for shopping with us!');
  }

  public function toArray($notifiable): array
  {
    return [
      'title' => 'Order Confirmation',
      'message' => 'Your order #' . $this->order->id . ' has been received.',
      'type' => 'order_created',
      'order_id' => $this->order->id
    ];
  }
}
