<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Permission\Models\Role;

class AuthController extends BaseController
{
    private function ensureRequiredRolesExist(): void
    {
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('superadmin', 'web');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->ensureRequiredRolesExist();

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required|in:admin,superadmin'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            if (!$user->hasRole($request->role)) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'role' => ["You don't have the selected role privileges."],
                ]);
            }

            $request->session()->regenerate();

            if ($user->hasRole('superadmin')) {
                return redirect()->intended('superadmin/dashboard');
            }
            return redirect()->intended('admin/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->ensureRequiredRolesExist();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,superadmin'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        Auth::login($user);

        if ($user->hasRole('superadmin')) {
            return redirect('superadmin/dashboard');
        }
        return redirect('admin/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
