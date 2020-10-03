<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
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
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Superadmin']);
          $role1->givePermissionTo('create-user');
          $role1->givePermissionTo('view-user');
          $role1->givePermissionTo('edit-user');
          $role1->givePermissionTo('delete-user');
        $role2 = Role::create(['name' => 'User']);

        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = Factory(App\User::class)->create([
            'name' => 'Superadmin',
            'email' => 'superadmin@superadmin.com',
        ]);
        $user->assignRole($role1);

        $user = Factory(App\User::class)->create([
            'name' => 'User',
            'email' => 'user@user.com',
        ]);
        $user->assignRole($role2);

    }
}
