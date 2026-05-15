<div wire:poll.10s>
    @if($alerts->isEmpty())
        <div class="text-sm text-text-secondary italic">No active alerts.</div>
    @else
        <ul class="space-y-3">
            @foreach($alerts as $alert)
                <li class="flex items-center justify-between p-3 rounded-lg border {{ $alert->type === 'out_of_stock' ? 'bg-red-50 border-alert-red' : 'bg-amber-50 border-alert-amber' }}">
                    <div>
                        <div class="font-medium {{ $alert->type === 'out_of_stock' ? 'text-alert-red' : 'text-alert-amber' }}">
                            {{ $alert->product->name }}
                        </div>
                        <div class="text-xs text-text-secondary">Quantity: {{ $alert->product->stock()->where('location_id', $alert->location_id)->value('quantity') ?? 0 }}</div>
                    </div>
                    <button wire:click="resolveAlert({{ $alert->id }})" class="text-xs px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-50 shadow-sm">
                        Dismiss
                    </button>
                </li>
            @endforeach
        </ul>
    @endif
</div>
