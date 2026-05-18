<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    public $users, $editingId, $name, $email, $password, $password_confirmation;
    public $isEditing = false;
    public $isCreating = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::orderBy('name')->get();
    }

    public function create()
    {
        $this->isCreating = true;
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'editingId']);
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->editingId = $id;
        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->reset(['password', 'password_confirmation']);
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->isCreating = false;
        $this->editingId = null;
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
    }

    public function save()
    {
        if ($this->isCreating) {
            $this->validate($this->rules);
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            session()->flash('message', 'User created successfully.');
        } else {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $this->editingId,
            ]);
            $user = User::find($this->editingId);
            $user->update(['name' => $this->name, 'email' => $this->email]);
            session()->flash('message', 'User updated successfully.');
        }
        $this->cancel();
        $this->loadUsers();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User deleted successfully.');
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.user-management');
    }
}
