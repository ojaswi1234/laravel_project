<div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-text-primary">Stock Overview</h3>
        <div class="flex space-x-2">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, SKU..." class="rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
            <select wire:model.live="locationFilter" class="rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50 text-sm">
                <option value="">All Locations</option>
                @foreach(\App\Models\Location::all() as $loc)
                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-green-border text-sm text-text-secondary">
                    <th class="pb-3 px-4 font-medium">Product / SKU</th>
                    <th class="pb-3 px-4 font-medium">Category</th>
                    <th class="pb-3 px-4 font-medium">Location</th>
                    <th class="pb-3 px-4 font-medium">Quantity</th>
                    <th class="pb-3 px-4 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($stocks as $stock)
                    <tr class="border-b border-gray-100 hover:bg-green-light/50 transition-colors">
                        <td class="py-3 px-4">
                            <div class="font-medium text-text-primary">{{ $stock->product->name }}</div>
                            <div class="text-xs text-text-secondary">{{ $stock->product->sku }}</div>
                        </td>
                        <td class="py-3 px-4">{{ $stock->product->category ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $stock->location->name }}</td>
                        <td class="py-3 px-4 font-medium">{{ $stock->quantity }} {{ $stock->product->unit }}</td>
                        <td class="py-3 px-4">
                            @if($stock->quantity <= 0)
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-alert-red border border-red-200">Out of Stock</span>
                            @elseif($stock->quantity < $stock->product->reorder_level)
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-alert-amber border border-amber-200">Low Stock</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-dark border border-green-200">OK</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 px-4 text-center text-text-secondary italic">No stock records found matching your filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $stocks->links() }}
    </div>
</div>
