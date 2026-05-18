<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StockChart extends Component
{
    public $days = 7;

    public function updatedDays()
    {
        $movementData = StockMovement::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(CASE WHEN LOWER(type) = "in" THEN quantity ELSE 0 END) as total_in'),
            DB::raw('SUM(CASE WHEN LOWER(type) = "out" THEN quantity ELSE 0 END) as total_out')
        )
        ->where('created_at', '>=', now()->subDays($this->days))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $labels = $movementData->pluck('date')->toArray();
        $inData = $movementData->pluck('total_in')->toArray();
        $outData = $movementData->pluck('total_out')->toArray();

        $this->dispatch('chart-updated', labels: $labels, inData: $inData, outData: $outData);
    }

    public function render()
    {
        $movementData = StockMovement::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(CASE WHEN LOWER(type) = "in" THEN quantity ELSE 0 END) as total_in'),
            DB::raw('SUM(CASE WHEN LOWER(type) = "out" THEN quantity ELSE 0 END) as total_out')
        )
        ->where('created_at', '>=', now()->subDays($this->days))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $labels = $movementData->pluck('date')->toArray();
        $inData = $movementData->pluck('total_in')->toArray();
        $outData = $movementData->pluck('total_out')->toArray();

        return view('livewire.stock-chart', [
            'labels' => $labels,
            'inData' => $inData,
            'outData' => $outData,
        ]);
    }
}
