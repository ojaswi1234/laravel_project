@extends('layouts.app')
@section('header', 'Locations')
@section('content')
    <div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
        <h3 class="text-lg font-medium text-text-primary uppercase mb-4">Locations Management</h3>
        @livewire('location-management')
    </div>
@endsection
