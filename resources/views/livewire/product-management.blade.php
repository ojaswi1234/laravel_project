<div>
    @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if($isCreating || $isEditing)
        <div class="mb-6 p-4 border rounded bg-gray-50">
            <h4 class="font-bold mb-4">{{ $isCreating ? 'Add New Product' : 'Edit Product' }}</h4>
            <div class="grid gap-3 mb-4">
                <div>
                    <input type="text" wire:model="name" class="w-full border p-2 rounded @error('name') border-red-500 @enderror" placeholder="Name">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <input type="text" wire:model="sku" class="w-full border p-2 rounded @error('sku') border-red-500 @enderror" placeholder="SKU">
                    @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <input type="number" wire:model="reorder_level" class="w-full border p-2 rounded @error('reorder_level') border-red-500 @enderror" placeholder="Reorder Level">
                    @error('reorder_level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <button wire:click="save" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
            <button wire:click="cancel" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
        </div>
    @else
        <button wire:click="create" class="mb-4 bg-green-600 text-white px-4 py-2 rounded">+ Add New Product</button>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y border-b border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">ID</th>
                    <th class="px-6 py-3 text-left font-medium">Name</th>
                    <th class="px-6 py-3 text-left font-medium">SKU</th>
                    <th class="px-6 py-3 text-left font-medium">Reorder Level</th>
                    <th class="px-6 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $p)
                <tr>
                    <td class="px-6 py-4">{{ $p->id }}</td>
                    <td class="px-6 py-4">{{ $p->name }}</td>
                    <td class="px-6 py-4">{{ $p->sku }}</td>
                    <td class="px-6 py-4">{{ $p->reorder_level }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button wire:click="edit({{ $p->id }})" class="text-blue-600 hover:underline">Edit</button>
                        <button wire:click="delete({{ $p->id }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" class="text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
