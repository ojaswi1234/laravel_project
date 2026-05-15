<div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
    <h3 class="text-lg font-medium text-text-primary mb-4">Transfer Stock</h3>
    
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-dark px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="submit" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-text-primary mb-1">Product</label>
            <select wire:model="product_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
                <option value="">Select Product...</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
            @error('product_id') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1">Source Location</label>
                <select wire:model="source_location_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
                    <option value="">From...</option>
                    @foreach($locations as $l)
                        <option value="{{ $l->id }}">{{ $l->name }}</option>
                    @endforeach
                </select>
                @error('source_location_id') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1">Destination Location</label>
                <select wire:model="destination_location_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
                    <option value="">To...</option>
                    @foreach($locations as $l)
                        <option value="{{ $l->id }}">{{ $l->name }}</option>
                    @endforeach
                </select>
                @error('destination_location_id') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1">Quantity</label>
            <input type="number" wire:model="quantity" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
            @error('quantity') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1">Notes</label>
            <input type="text" wire:model="reason" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
            @error('reason') <span class="text-xs text-alert-red">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-medium hover:bg-blue-700 transition-colors">Execute Transfer</button>
    </form>
</div>
