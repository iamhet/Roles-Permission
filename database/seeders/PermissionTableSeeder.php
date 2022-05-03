<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'module1-create',
            'module1-view',
            'module1-edit',
            'module1-delete',
            'module2-create',
            'module2-view',
            'module2-edit',
            'module2-delete',
            'module3-create',
            'module3-view',
            'module3-edit',
            'module3-delete',
            'role-view',
            'role-create',
            'role-edit',
            'role-delete',
            'user-create',
            'user-view',
            'user-edit',
            'user-delete',            
        ];
        $roles = new Role();
        $roles->name = "admin";
        $roles->guard_name = "web";
        $roles->save();
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $roles->syncPermissions($permissions);
        $user = new User();
        $user->name = "admin";
        $user->email = "admin@admin.com";
        $user->password = Hash::make(123456789);
        $user->save();
        $user->assignRole("admin");

    }
}
