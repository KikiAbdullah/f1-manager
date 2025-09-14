<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        $permissions = [
            //users
            'users_view',
            'users_add',
            'users_edit',
            'users_delete',
            //users

            //roles
            'roles_view',
            'roles_add',
            'roles_edit',
            'roles_delete',
            //roles

            //permissions
            'permissions_view',
            'permissions_add',
            'permissions_edit',
            'permissions_delete',
            //permissions
        ];

        foreach ($permissions as $permission) {
            if (Permission::where('name', $permission)->count() <= 0) {
                Permission::create(['name' => $permission]);
            }
        }

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'SUPERADMIN']);

        $role2 = Role::create(['name' => 'ADMIN']);

        $user = \App\User::find(1);
        $user->assignRole($role1);
    }
}
