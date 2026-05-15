<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Location;
use App\Models\Product;
use App\Models\Stock;
use Spatie\Permission\PermissionRegistrar;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $superAdminRole = Role::findOrCreate('superadmin', 'web');
        $adminRole = Role::findOrCreate('admin', 'web');

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@stocksync.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        $admin = User::create([
            'name' => 'Store Manager',
            'email' => 'admin@stocksync.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        $loc = Location::create([
            'name' => 'Main Warehouse',
            'city' => 'New York',
            'manager_id' => $admin->id
        ]);

        $prod = Product::create([
            'sku' => 'SKU-001',
            'name' => 'Test Product',
            'reorder_level' => 10,
        ]);

        Stock::create([
            'product_id' => $prod->id,
            'location_id' => $loc->id,
            'quantity' => 50,
        ]);
    }
}
