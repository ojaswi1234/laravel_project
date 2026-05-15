<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StockSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-green-light font-sans text-text-primary antialiased flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-60 bg-green-dark text-white flex flex-col">
        <div class="h-16 flex items-center px-6 font-semibold text-xl tracking-tight border-b border-green-primary">
            <svg class="w-6 h-6 mr-2 text-green-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2L2 7l1.5 1.5L10 5l6.5 3.5L18 7l-8-5z"/><path d="M2 13l8 5 8-5v-2l-8 5-8-5v2z"/></svg>
            StockSync
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            @role('superadmin')
                <a href="{{ route('superadmin.dashboard') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('superadmin.dashboard') ? 'bg-green-primary' : 'hover:bg-green-primary/50' }}">Dashboard</a>
                <a href="{{ route('superadmin.locations') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('superadmin.locations') ? 'bg-green-primary' : 'hover:bg-green-primary/50' }}">Locations</a>
                <a href="{{ route('superadmin.products') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('superadmin.products') ? 'bg-green-primary' : 'hover:bg-green-primary/50' }}">Products</a>
                <a href="{{ route('superadmin.stock') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('superadmin.stock') ? 'bg-green-primary' : 'hover:bg-green-primary/50' }}">Stock Overview</a>
                <a href="{{ route('superadmin.users') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('superadmin.users') ? 'bg-green-primary' : 'hover:bg-green-primary/50' }}">Users</a>
            @endrole
            @role('admin')
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-green-primary' : 'hover:bg-green-primary/50' }}">Dashboard</a>
                <a href="{{ route('admin.stock') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('admin.stock') ? 'bg-green-primary' : 'hover:bg-green-primary/50' }}">My Location Stock</a>
            @endrole
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0">
            <div class="text-sm text-text-secondary font-medium uppercase tracking-wider">
                @yield('header')
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-sm font-medium text-text-primary">{{ auth()->user()->name }}</div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-light text-green-dark border border-green-border">
                    {{ auth()->user()->roles->first()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-alert-red hover:underline">Logout</button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 max-w-7xl mx-auto w-full">
            @yield('content')
        </main>
    </div>
    @livewireScripts
</body>
</html>
