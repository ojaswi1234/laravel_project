<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Location;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use App\Events\StockUpdated;
use App\Events\StockTransferCreated;

class TransferForm extends Component
{
    public $product_id = '';
    public $source_location_id = '';
    public $destination_location_id = '';
    public $quantity = 1;
    public $reason = '';

    protected $rules = [
        'product_id' => 'required|exists:products,id',
        'source_location_id' => 'required|exists:locations,id',
        'destination_location_id' => 'required|exists:locations,id|different:source_location_id',
        'quantity' => 'required|integer|min:1',
        'reason' => 'nullable|string|max:255',
    ];

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $sourceStock = Stock::where('product_id', $this->product_id)
                ->where('location_id', $this->source_location_id)
                ->first();

            if (!$sourceStock || $sourceStock->quantity < $this->quantity) {
                $this->addError('quantity', 'Insufficient stock at source location.');
                return;
            }

            $destStock = Stock::firstOrCreate(
                ['product_id' => $this->product_id, 'location_id' => $this->destination_location_id],
                ['quantity' => 0]
            );

            // Deduct from source
            $sourceStock->quantity -= $this->quantity;
            $sourceStock->save();

            // Add to dest
            $destStock->quantity += $this->quantity;
            $destStock->save();

            // Record movements
            StockMovement::create([
                'stock_id' => $sourceStock->id,
                'type' => 'OUT',
                'quantity' => $this->quantity,
                'reason' => 'Transfer to ' . $destStock->location->name . ($this->reason ? ': ' . $this->reason : ''),
                'user_id' => auth()->id(),
            ]);

            StockMovement::create([
                'stock_id' => $destStock->id,
                'type' => 'IN',
                'quantity' => $this->quantity,
                'reason' => 'Transfer from ' . $sourceStock->location->name . ($this->reason ? ': ' . $this->reason : ''),
                'user_id' => auth()->id(),
            ]);

            event(new StockUpdated($sourceStock));
            event(new StockUpdated($destStock));
            // Ensure this event exists if called
            if (class_exists(StockTransferCreated::class)) {
                // event(new StockTransferCreated(...));
            }

            $this->reset(['product_id', 'source_location_id', 'destination_location_id', 'quantity', 'reason']);
            session()->flash('message', 'Stock transfer completed.');
        });
    }

    public function render()
    {
        return view('livewire.transfer-form', [
            'products' => Product::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
        ]);
    }
}
