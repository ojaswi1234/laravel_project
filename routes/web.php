<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', function () { return view('superadmin.dashboard'); })->name('dashboard');
        // Placeholders for other routes
        Route::get('/locations', function () { return view('superadmin.locations'); })->name('locations');
        Route::get('/products', function () { return view('superadmin.products'); })->name('products');
        Route::get('/stock', function () { return view('superadmin.stock'); })->name('stock');
        Route::get('/movements', function () { return view('superadmin.movements'); })->name('movements');
        Route::get('/transfers', function () { return view('superadmin.transfers'); })->name('transfers');
        Route::get('/alerts', function () { return view('superadmin.alerts'); })->name('alerts');
        Route::get('/users', function () { return view('superadmin.users'); })->name('users');
        Route::get('/reports', function () { return view('superadmin.reports'); })->name('reports');
        Route::get('/settings', function () { return view('superadmin.settings'); })->name('settings');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
        Route::get('/stock', function () { return view('admin.stock'); })->name('stock');
        Route::get('/movements', function () { return view('admin.movements'); })->name('movements');
        Route::get('/transfers', function () { return view('admin.transfers'); })->name('transfers');
        Route::get('/alerts', function () { return view('admin.alerts'); })->name('alerts');
        Route::get('/reports', function () { return view('admin.reports'); })->name('reports');
    });
});
