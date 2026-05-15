@extends('layouts.app')
@section('header', ucfirst('products'))
@section('content')
    <div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
        <h3 class="text-lg font-medium text-text-primary uppercase">{{ 'products' }} Page</h3>
        <p class="text-text-secondary mt-2">Placeholder for products.</p>
    </div>
@endsection
