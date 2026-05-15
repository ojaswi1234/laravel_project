<?php

namespace App\Jobs;

use App\Models\Alert;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAlertNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $alert_id, public int $user_id) {}

    public function handle(): void
    {
        $alert = Alert::with(['product', 'location'])->find($this->alert_id);
        $user = User::find($this->user_id);
        if ($alert && $user) {
            $user->notify(new LowStockNotification($alert));
        }
    }
}
