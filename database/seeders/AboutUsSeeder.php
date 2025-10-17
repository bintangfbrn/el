<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AboutUsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view_aboutus',
            'create_aboutus',
            'edit_aboutus',
            'delete_aboutus',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        $roles = Role::with(['permissions'])->get();

        foreach ($roles as $role) {
            if ($role->name == 'superadmin') {
                $role->givePermissionTo($permissions);
            }
        }
    }
}
