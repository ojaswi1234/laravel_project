@extends('layouts.app')
@section('header', 'Super Admin Dashboard')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Stats Cards -->
        <div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
            <h4 class="text-sm font-medium text-text-secondary">Total Products</h4>
            <p class="text-3xl font-bold text-green-dark">{{ \App\Models\Product::count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
            <h4 class="text-sm font-medium text-text-secondary">Total Value</h4>
            <p class="text-3xl font-bold text-green-dark">₹{{ number_format(\App\Models\Stock::join('products', 'stock.product_id', '=', 'products.id')->sum(\Illuminate\Support\Facades\DB::raw('stock.quantity * products.unit_price')), 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
            <h4 class="text-sm font-medium text-text-secondary">Active Alerts</h4>
            <p class="text-3xl font-bold text-alert-red">{{ \App\Models\Alert::where('is_resolved', false)->count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-6">
        <livewire:alert-feed />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2">
            <livewire:stock-chart />
        </div>
        <div>
            <livewire:live-activity-feed />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <livewire:movement-form />
        <livewire:transfer-form />
    </div>
@endsection
