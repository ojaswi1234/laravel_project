@extends('layouts.app')
@section('header', 'Users')
@section('content')
    <div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
        <h3 class="text-lg font-medium text-text-primary uppercase mb-4">Users Management</h3>
        @livewire('user-management')
    </div>
@endsection
