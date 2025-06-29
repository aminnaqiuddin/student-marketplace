<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\OrderItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProductSoldNotification extends Notification
{
    use Queueable;

    public $orderItem;

    public function __construct(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
    }

    public function via($notifiable)
    {
        return ['database']; // use ['mail', 'database'] if you want both later
    }

    public function toArray($notifiable)
    {
        return [
            'product_title' => $this->orderItem->title,
            'buyer_name' => $this->orderItem->order->name,
            'order_id' => $this->orderItem->order_id,
            'product_id' => $this->orderItem->product_id,
            'message' => "Your product '{$this->orderItem->title}' was purchased by {$this->orderItem->order->name}.",
        ];
    }
}

