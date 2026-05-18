<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Location;

class LocationManagement extends Component
{
    public $locations, $editingId, $name, $city;
    public $isEditing = false;
    public $isCreating = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'city' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadLocations();
    }

    public function loadLocations()
    {
        $this->locations = Location::orderBy('name')->get();
    }

    public function create()
    {
        $this->isCreating = true;
        $this->reset(['name', 'city', 'editingId']);
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->editingId = $id;
        $location = Location::find($id);
        $this->name = $location->name;
        $this->city = $location->city;
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->isCreating = false;
        $this->editingId = null;
        $this->reset(['name', 'city']);
    }

    public function save()
    {
        $this->validate($this->rules);
        if ($this->isCreating) {
            Location::create(['name' => $this->name, 'city' => $this->city]);
            session()->flash('message', 'Location created successfully.');
        } else {
            $location = Location::find($this->editingId);
            $location->update(['name' => $this->name, 'city' => $this->city]);
            session()->flash('message', 'Location updated successfully.');
        }
        $this->cancel();
        $this->loadLocations();
    }

    public function delete($id)
    {
        Location::find($id)->delete();
        session()->flash('message', 'Location deleted successfully.');
        $this->loadLocations();
    }

    public function render()
    {
        return view('livewire.location-management');
    }
}
