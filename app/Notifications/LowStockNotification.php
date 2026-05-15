<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Alert;

class LowStockNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Alert $alert) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Stock Alert: ' . $this->alert->product->name)
                    ->line('The stock for ' . $this->alert->product->name . ' is currently running low at ' . $this->alert->location->name . '.')
                    ->action('View Dashboard', url('/admin/dashboard'))
                    ->line('Please restock soon!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'alert_id' => $this->alert->id,
            'product_name' => $this->alert->product->name,
            'location_name' => $this->alert->location->name,
            'type' => $this->alert->type,
        ];
    }
}
