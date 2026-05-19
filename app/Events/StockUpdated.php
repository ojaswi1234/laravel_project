<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $product_id,
        public int $location_id,
        public float $new_quantity,
        public int $updated_by,
        public string $timestamp
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('stock.'.$this->location_id),
            new Channel('stock'),
        ];
    }
}
