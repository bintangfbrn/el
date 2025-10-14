<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class DesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissionList = [
            // Permission untuk modul desain
            'view_design',
            'create_design',
            'edit_design',
            'delete_design',
        ];

        foreach ($permissionList as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        Role::create([
            'name' => 'designer',
            'guard_name' => 'web',
        ])->givePermissionTo($permissionList);

        User::create([
            'name' => 'designer',
            'email' => 'designer@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('designer');
    }
}
