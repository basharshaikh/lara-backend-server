<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit_blog']);
        Permission::create(['name' => 'delete_blog']);
        Permission::create(['name' => 'edit_project']);
        Permission::create(['name' => 'delete_project']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'blogger']);
        $role1->givePermissionTo('edit_blog');
        $role1->givePermissionTo('delete_blog');

        $role2 = Role::create(['name' => 'project_manager']);
        $role2->givePermissionTo('edit_project');
        $role2->givePermissionTo('delete_project');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
        ]);
        $user->assignRole($role3);
    }
}


// $user = $request->user()
// $user = auth()->user()
// $user->hasRole('roleName')
// $user->can('permissionName')