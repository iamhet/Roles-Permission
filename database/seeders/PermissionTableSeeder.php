<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

    }
}
