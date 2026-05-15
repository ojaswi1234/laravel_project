<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Models\Alert;
use App\Events\LowStockAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckLowStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $product_id, public int $location_id) {}

    public function handle(): void
    {
        $stock = Stock::where('product_id', $this->product_id)
            ->where('location_id', $this->location_id)
            ->with(['product', 'location'])
            ->first();

        if (!$stock || !$stock->product) return;

        $isLowStock = $stock->quantity < $stock->product->reorder_level;
        $isOutOfStock = $stock->quantity <= 0;
        
        $type = null;
        if ($isOutOfStock) {
            $type = 'out_of_stock';
        } elseif ($isLowStock) {
            $type = 'low_stock';
        }

        if ($type) {
            $alert = Alert::firstOrCreate(
                ['product_id' => $this->product_id, 'location_id' => $this->location_id, 'is_resolved' => false],
                ['type' => $type]
            );

            if ($alert->wasRecentlyCreated || $alert->type !== $type) {
                if (!$alert->wasRecentlyCreated) {
                    $alert->type = $type;
                    $alert->save();
                }

                $alertData = [
                    'id' => $alert->id,
                    'product_name' => $stock->product->name,
                    'quantity' => $stock->quantity,
                    'type' => $type,
                ];

                broadcast(new LowStockAlert($this->location_id, $alertData));
                
                if ($stock->location->manager_id) {
                    SendAlertNotificationJob::dispatch($alert->id, $stock->location->manager_id);
                }
            }
        } else {
            Alert::where('product_id', $this->product_id)
                ->where('location_id', $this->location_id)
                ->where('is_resolved', false)
                ->update(['is_resolved' => true, 'resolved_at' => now()]);
        }
    }
}
