<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Buat Permission
        Permission::create(['name' => 'access-manage-user']);
        Permission::create(['name' => 'access-template']);

        // Buat Role dan Assign Permission
        $adminRole = Role::create(['name' => 'superadmin']);
        $adminRole->givePermissionTo(['access-manage-user', 'access-template']);

        $userRole = Role::create(['name' => 'admin']);
        $userRole->givePermissionTo(['access-template']);

        // $user = User::find(1); // Ganti ID user
        // $user->assignRole('admin');
    }
}
