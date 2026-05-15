<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Stock;
use Livewire\Attributes\On;

class StockTable extends Component
{
    use WithPagination;

    public $search = '';
    public $locationFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingLocationFilter()
    {
        $this->resetPage();
    }

    #[On('echo:stock.*,StockUpdated')]
    public function handleStockUpdate($payload)
    {
        // Re-render implicitly handled by livewire reacting
    }

    public function render()
    {
        $query = Stock::with(['product', 'location']);

        if ($this->search) {
            $query->whereHas('product', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->locationFilter) {
            $query->where('location_id', $this->locationFilter);
        }

        return view('livewire.stock-table', [
            'stocks' => $query->paginate(10)
        ]);
    }
}
