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

        $loc1 = Location::create([
            'name' => 'Mumbai Godown',
            'city' => 'Mumbai',
            'manager_id' => $admin->id
        ]);
        $loc2 = Location::create([
            'name' => 'Delhi Distribution Center',
            'city' => 'Delhi',
            'manager_id' => $superAdmin->id
        ]);

        $prod1 = Product::create([
            'sku' => 'MDH-MASALA-01',
            'name' => 'MDH Garam Masala 100g',
            'reorder_level' => 20,
        ]);
        $prod2 = Product::create([
            'sku' => 'AMUL-BUTTER-500',
            'name' => 'Amul Butter 500g',
            'reorder_level' => 50,
        ]);
        $prod3 = Product::create([
            'sku' => 'PARLE-G-150',
            'name' => 'Parle-G Biscuits 150g',
            'reorder_level' => 100,
        ]);
        $prod4 = Product::create([
            'sku' => 'MAGGI-NOODLES-04',
            'name' => 'Maggi 2-Minute Noodles 4-pack',
            'reorder_level' => 150,
        ]);

        Stock::create(['product_id' => $prod1->id, 'location_id' => $loc1->id, 'quantity' => 120]);
        Stock::create(['product_id' => $prod2->id, 'location_id' => $loc1->id, 'quantity' => 45]);
        Stock::create(['product_id' => $prod3->id, 'location_id' => $loc2->id, 'quantity' => 250]);
        Stock::create(['product_id' => $prod4->id, 'location_id' => $loc2->id, 'quantity' => 300]);
        Stock::create(['product_id' => $prod1->id, 'location_id' => $loc2->id, 'quantity' => 15]); // Low stock
    }
}
