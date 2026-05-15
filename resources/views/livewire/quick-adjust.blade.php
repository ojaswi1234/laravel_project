<div>
    <form wire:submit="adjust" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-text-primary mb-1">Product</label>
            <select wire:model="product_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50" required>
                <option value="">Select a product...</option>
                @foreach(\App\Models\Product::all() as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                @endforeach
            </select>
            @error('product_id') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
        </div>
        <div class="flex space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-text-primary mb-1">Adjustment Type</label>
                <select wire:model="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50" required>
                    <option value="in">Add (+)</option>
                    <option value="out">Remove (-)</option>
                </select>
                @error('type') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-text-primary mb-1">Quantity</label>
                <input type="number" wire:model="quantity" min="1" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50" required>
                @error('quantity') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
            </div>
        </div>
        <button type="submit" class="w-full bg-green-primary text-white py-2 rounded-md font-medium hover:bg-green-dark transition-colors">
            Update Stock
        </button>
    </form>
    @if(session('message'))
        <div class="mt-4 p-3 bg-green-light border border-green-border text-green-dark text-sm rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
