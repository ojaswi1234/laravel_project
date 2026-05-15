<div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
    <h3 class="text-lg font-medium text-text-primary mb-4">Record Movement</h3>
    
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-dark px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="submit" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1">Product</label>
                <select wire:model="product_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
                    <option value="">Select Product...</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->sku }})</option>
                    @endforeach
                </select>
                @error('product_id') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1">Location</label>
                <select wire:model="location_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
                    <option value="">Select Location...</option>
                    @foreach($locations as $l)
                        <option value="{{ $l->id }}">{{ $l->name }}</option>
                    @endforeach
                </select>
                @error('location_id') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1">Type</label>
                <select wire:model="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
                    <option value="IN">Stock IN (+)</option>
                    <option value="OUT">Stock OUT (-)</option>
                    <option value="ADJUSTMENT">Adjustment (=)</option>
                </select>
                @error('type') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1">Quantity</label>
                <input type="number" wire:model="quantity" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
                @error('quantity') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1">Reason (Optional)</label>
            <input type="text" wire:model="reason" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
            @error('reason') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-green-primary text-white py-2 rounded-md font-medium hover:bg-green-dark transition-colors">Record Movement</button>
    </form>
</div>
