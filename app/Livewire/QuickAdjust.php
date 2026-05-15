<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Location;
use App\Events\StockUpdated;
use Illuminate\Support\Facades\Auth;

class QuickAdjust extends Component
{
    public $product_id;
    public $type = 'in';
    public $quantity;

    public function adjust()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01'
        ]);

        $user = Auth::user();
        if(!$user) return;
        
        $location = Location::where('manager_id', $user->id)->first();
        if(!$location) {
            session()->flash('message', 'No location assigned to your account.');
            return;
        }

        $stock = Stock::firstOrCreate(
            ['product_id' => $this->product_id, 'location_id' => $location->id],
            ['quantity' => 0]
        );

        $adjustment = $this->type === 'in' ? $this->quantity : -$this->quantity;
        $stock->quantity += $adjustment;
        $stock->last_updated_at = now();
        $stock->updated_by = $user->id;
        $stock->save();

        StockMovement::create([
            'product_id' => $this->product_id,
            'from_location_id' => $this->type === 'out' ? $location->id : null,
            'to_location_id' => $this->type === 'in' ? $location->id : null,
            'quantity' => $this->quantity,
            'type' => 'adjustment',
            'created_by' => $user->id
        ]);

        broadcast(new StockUpdated($this->product_id, $location->id, $stock->quantity, $user->id, now()->toDateTimeString()));

        session()->flash('message', 'Stock adjusted successfully!');
        $this->reset(['product_id', 'quantity']);
    }

    public function render()
    {
        return view('livewire.quick-adjust');
    }
}
