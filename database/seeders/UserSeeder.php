<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissionList = [
            'view_user',
            'create_user',
            'edit_user',
            'delete_user',
            'view_role',
            'create_role',
            'edit_role',
            'delete_role',
            'view_permission',
            'create_permission',
            'edit_permission',
            'delete_permission',
        ];

        foreach ($permissionList as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web',
        ])->givePermissionTo($permissionList);

        User::create([
            'name' => 'superadmin',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('superadmin');
    }
}
