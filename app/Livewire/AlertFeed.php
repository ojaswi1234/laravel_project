<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Alert;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class AlertFeed extends Component
{
    public function resolveAlert($id)
    {
        $alert = Alert::find($id);
        if ($alert) {
            $alert->is_resolved = true;
            $alert->resolved_at = now();
            $alert->save();
        }
    }

    #[On('echo:alerts,LowStockAlert')]
    public function handleAlert($payload)
    {
        // automatically handled by livewire re-rendering state
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user) return view('livewire.alert-feed', ['alerts' => collect()]);

        $query = Alert::with('product')
            ->where('is_resolved', false)
            ->orderBy('created_at', 'desc')
            ->take(5);

        if ($user->hasRole('admin')) {
            $locationId = $user->location?->id;
            if ($locationId) {
                $query->where('location_id', $locationId);
            }
        }

        return view('livewire.alert-feed', ['alerts' => $query->get()]);
    }
}
