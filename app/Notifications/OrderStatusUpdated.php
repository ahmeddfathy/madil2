<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $status = ucfirst($this->order->status);

        return (new MailMessage)
            ->subject("Order Status Updated: {$status}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your order #{$this->order->id} has been updated to {$status}.")
            ->when($this->order->notes, function ($message) {
                return $message->line("Notes: {$this->order->notes}");
            })
            ->action('View Order', route('orders.show', $this->order))
            ->line('Thank you for shopping with us!');
    }
}
