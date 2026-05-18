<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Location;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use App\Events\StockUpdated;

class MovementForm extends Component
{
    public $product_id = '';
    public $location_id = '';
    public $type = 'IN';
    public $quantity = 1;
    public $reason = '';

    protected $rules = [
        'product_id' => 'required|exists:products,id',
        'location_id' => 'required|exists:locations,id',
        'type' => 'required|in:IN,OUT,ADJUSTMENT',
        'quantity' => 'required|integer|min:1',
        'reason' => 'nullable|string|max:255',
    ];

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $stock = Stock::firstOrCreate(
                ['product_id' => $this->product_id, 'location_id' => $this->location_id],
                ['quantity' => 0]
            );

            if ($this->type === 'OUT' && $stock->quantity < $this->quantity) {
                $this->addError('quantity', 'Insufficient stock.');
                return;
            }

            $oldQuantity = $stock->quantity;
            $adjustment = $this->type === 'IN' ? $this->quantity : -$this->quantity;
            
            if ($this->type === 'ADJUSTMENT') {
                $adjustment = $this->quantity - $stock->quantity;
                $stock->quantity = $this->quantity;
            } else {
                $stock->quantity += $adjustment;
            }
            
            $stock->save();

            StockMovement::create([
                'product_id' => $this->product_id,
                'to_location_id' => $this->type === 'IN' || $this->type === 'ADJUSTMENT' ? $this->location_id : null,
                'from_location_id' => $this->type === 'OUT' ? $this->location_id : null,
                'type' => strtolower($this->type),
                'quantity' => abs($adjustment),
                'note' => $this->reason ?: 'Manual entry',
                'created_by' => auth()->id(),
            ]);

            event(new StockUpdated(
                $stock->product_id,
                $stock->location_id,
                $stock->quantity,
                auth()->id(),
                now()->toDateTimeString()
            ));

            $this->reset(['product_id', 'location_id', 'type', 'quantity', 'reason']);
            session()->flash('message', 'Stock movement recorded successfully.');
        });
    }

    public function render()
    {
        return view('livewire.movement-form', [
            'products' => Product::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
        ]);
    }
}
