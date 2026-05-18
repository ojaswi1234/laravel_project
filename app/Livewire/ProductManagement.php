<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductManagement extends Component
{
    public $products, $editingId, $name, $sku, $reorder_level;
    public $isEditing = false;
    public $isCreating = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:100|unique:products,sku',
        'reorder_level' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::orderBy('name')->get();
    }

    public function create()
    {
        $this->isCreating = true;
        $this->reset(['name', 'sku', 'reorder_level', 'editingId']);
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->editingId = $id;
        $product = Product::find($id);
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->reorder_level = $product->reorder_level;
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->isCreating = false;
        $this->editingId = null;
        $this->reset(['name', 'sku', 'reorder_level']);
    }

    public function save()
    {
        if ($this->isCreating) {
            $this->validate($this->rules);
            Product::create([
                'name' => $this->name,
                'sku' => $this->sku,
                'reorder_level' => $this->reorder_level,
            ]);
            session()->flash('message', 'Product created successfully.');
        } else {
            $this->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:100|unique:products,sku,' . $this->editingId,
                'reorder_level' => 'required|integer|min:1',
            ]);
            $product = Product::find($this->editingId);
            $product->update([
                'name' => $this->name,
                'sku' => $this->sku,
                'reorder_level' => $this->reorder_level,
            ]);
            session()->flash('message', 'Product updated successfully.');
        }
        $this->cancel();
        $this->loadProducts();
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'Product deleted successfully.');
        $this->loadProducts();
    }

    public function render()
    {
        return view('livewire.product-management');
    }
}
