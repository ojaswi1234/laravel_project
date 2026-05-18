<div class="bg-white p-6 rounded-lg border border-green-border shadow-hover h-full">
    <h3 class="text-lg font-medium text-text-primary mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-green-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Live Activity 
        <span class="ml-2 flex h-3 w-3 relative">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
        </span>
    </h3>
    <div class="space-y-4 overflow-y-auto max-h-[400px] pr-2">
        @forelse($movements as $movement)
            <div class="flex flex-col pb-3 border-b border-gray-100 last:border-0 text-sm">
                <div class="flex justify-between items-start">
                    <span class="font-medium text-text-primary">{{ $movement->product->name ?? 'Unknown Product' }}</span>
                    <span class="text-xs text-text-secondary">{{ $movement->created_at->diffForHumans() }}</span>
                </div>
                <div class="flex justify-between mt-1">
                    <span class="text-text-secondary">{{ $movement->toLocation ? $movement->toLocation->name : ($movement->fromLocation ? $movement->fromLocation->name : 'Unknown') }}</span>
                    <span class="font-semibold {{ in_array($movement->type, ['in', 'IN']) ? 'text-green-600' : (in_array($movement->type, ['out', 'OUT']) ? 'text-alert-red' : 'text-blue-600') }}">
                        {{ $movement->type === 'in' ? '+' : ($movement->type === 'out' ? '-' : '↔') }}{{ $movement->quantity }}
                    </span>
                </div>
                <div class="text-xs text-text-secondary mt-1">By {{ $movement->createdBy->name ?? 'System' }} {{ $movement->note ? '- ' . $movement->note : '' }}</div>
            </div>
        @empty
            <div class="text-sm text-text-secondary italic">No recent activity.</div>
        @endforelse
    </div>
</div>
