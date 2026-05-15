<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - StockSync</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-green-light flex items-center justify-center h-screen font-sans">
    <div class="bg-white p-8 rounded-lg shadow-hover border border-green-border w-full max-w-md">
        <h2 class="text-2xl font-semibold text-green-dark text-center mb-6">StockSync Login</h2>
        @if($errors->any())
            <div class="mb-4 text-alert-red text-sm text-center">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div class="flex space-x-4">
                <label class="flex-1 flex items-center p-3 border rounded cursor-pointer hover:bg-green-light border-green-border">
                    <input type="radio" name="role" value="admin" class="text-green-primary focus:ring-green-primary" required>
                    <span class="ml-2 text-sm font-medium">Store Manager</span>
                </label>
                <label class="flex-1 flex items-center p-3 border rounded cursor-pointer hover:bg-green-light border-green-border">
                    <input type="radio" name="role" value="superadmin" class="text-green-primary focus:ring-green-primary" required>
                    <span class="ml-2 text-sm font-medium">Super Admin</span>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1">Email</label>
                <input type="email" name="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1">Password</label>
                <input type="password" name="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-primary focus:ring focus:ring-green-primary focus:ring-opacity-50" required>
            </div>
            <button type="submit" class="w-full bg-green-primary text-white py-2.5 rounded-md font-medium hover:bg-green-dark transition-colors">Sign In</button>
        </form>
        <p class="mt-6 text-center text-sm text-text-secondary">
            Don't have an account? <a href="{{ route('register') }}" class="text-green-primary hover:underline">Register</a>
        </p>
    </div>
</body>
</html>
