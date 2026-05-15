@extends('layouts.app')
@section('header', 'Store Manager Dashboard')
@section('content')
<div class="bg-white p-6 rounded-lg border border-green-border shadow-hover mb-6">
    <h2 class="text-xl font-semibold text-green-dark mb-4">Welcome back, {{ auth()->user()->name }}</h2>
    <p class="text-text-secondary">Manage your specific location inventory and transfers here.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
        <h3 class="text-lg font-medium text-text-primary mb-4">Quick Adjust Stock</h3>
        <livewire:quick-adjust />
    </div>
    <div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
        <h3 class="text-lg font-medium text-text-primary mb-4">Recent Alerts</h3>
        <livewire:alert-feed />
    </div>
</div>
@endsection
