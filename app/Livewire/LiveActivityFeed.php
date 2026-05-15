<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StockMovement;
use Livewire\Attributes\On;

class LiveActivityFeed extends Component
{
    public $limit = 10;

    #[On('echo:stock.*,StockUpdated')]
    public function handleStockUpdate($payload)
    {
        // View implicitly re-renders
    }

    public function render()
    {
        return view('livewire.live-activity-feed', [
            'movements' => StockMovement::with(['stock.product', 'stock.location', 'user'])
                ->latest()
                ->take($this->limit)
                ->get()
        ]);
    }
}
