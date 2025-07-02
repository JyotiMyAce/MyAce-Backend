<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'listing-view',
            'listing-create',
            'listing-edit',
            'listing-delete',
            'admin-view',
            'admin-create',
            'admin-edit',
            'admin-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'admin', // Explicitly set guard_name to 'admin'
            ]);
        }
    }
}