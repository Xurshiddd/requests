<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $permission = Permission::create(['name' => 'change-status']);
        $role = Role::create(['name' => 'SuperAdmin']);
        $role->givePermissionTo($permission->name);
        $user = User::where('id', 1)->first();
        $user->assignRole('Super Admin');
    }
}
