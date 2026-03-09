<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Assign all permissions to Admin Role
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        $user = User::firstOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('password'),
            'type' => \App\Enums\UserType::ADMIN,
        ]);

        // Assign Role to User
        $user->assignRole($role);
    }
}
