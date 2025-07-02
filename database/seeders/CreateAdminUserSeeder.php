<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $superAdminRole = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'admin']);
        $listingRole = Role::create(['name' => 'Listing', 'guard_name' => 'admin']);

        // Assign permissions to roles
        $adminPermissions = [
            'admin-view',
            'admin-create',
            'admin-edit',
            'listing-view',
            'listing-create',
            'listing-edit',
        ];
        $listingPermissions = [
            'listing-view',
            'listing-create',
        ];

        $adminRole->syncPermissions($adminPermissions);
        $listingRole->syncPermissions($listingPermissions);
        // Super Admin gets all permissions via Gate::before, so no need to assign

        // Create sample admin users
        $superAdmin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $admin->assignRole($adminRole);

        $listingUser = Admin::create([
            'name' => 'Listing User',
            'email' => 'listing@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $listingUser->assignRole($listingRole);
    }
}
