<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $dashboard = json_encode(["action" => "read", "subject" => "Dashboard"]);
        $profile = json_encode(["action" => "read", "subject" => "Profile"]);
        $unauth = json_encode(["action" => "read", "subject" => "Unautherize"]);
        $unlocking = json_encode(["action" => "read", "subject" => "Unlocking"]);
        $calculator = json_encode(["action" => "read", "subject" => "Calculator"]);
        $users = json_encode(["action" => "read", "subject" => "Users"]);
        $managemenu = json_encode(["action" => "read", "subject" => "Managemenu"]);
        $all = json_encode(["action" => "manage", "subject" => "all"]);
        // $permission = new  Permission;
        // $permission->name = 'Dashboard';
        // $permission->permission_string = $dashboard;
        // $permission = new  Permission;
        // $permission->name = 'Profile';
        // $permission->permission_string = $profile;
        // $permission->save();
        // $permission = new  Permission;
        // $permission->name = 'Unautherize';
        // $permission->permission_string = $unauth;
        // $permission->save();
        // $permission = new  Permission;
        // $permission->name = 'Unlocking';
        // $permission->permission_string = $unlocking;
        // $permission->save();
        // $permission = new  Permission;
        // $permission->name = 'Calculator';
        // $permission->permission_string = $calculator;
        // $permission->save();
        // $permission = new  Permission;
        // $permission->name = 'Users';
        // $permission->permission_string = $users;
        // $permission->save();
        // $permission = new  Permission;
        // $permission->name = 'Managemenu';
        // $permission->permission_string = $managemenu;
        // $permission->save();
        // $permission = new  Permission;
        // $permission->name = 'All';
        // $permission->permission_string = $all;
        // $permission->save();
        $permission = Permission::create(['name' => 'Dashboard', 'permission_string' => $dashboard]);
        $permission = Permission::create(['name' => 'Profile', 'permission_string' => $profile]);
        $permission = Permission::create(['name' => 'Unautherize', 'permission_string' => $unauth]);
        $permission = Permission::create(['name' => 'Unlocking', 'permission_string' => $unlocking]);
        $permission = Permission::create(['name' => 'Calculator', 'permission_string' => $calculator]);
        $permission = Permission::create(['name' => 'Users', 'permission_string' => $users]);
        $permission = Permission::create(['name' => 'Managemenu', 'permission_string' => $managemenu]);
        $permission = Permission::create(['name' => 'All', 'permission_string' => $all]);
        // create roles and assign created permissions
        // this can be done as separate statements
        $admin = Role::create(['name' => 'Admin']);
        $client = Role::create(['name' => 'Client']);
        $editor = Role::create(['name' => 'Editor']);
        $manager = Role::create(['name' => 'Manager']);
        $admin->givePermissionTo('All');
        $users = User::get();
        foreach ($users as $key => $user) {
            $user->assignRole($user->role);
        }
        User::where('role', 'admin')->update(['role' => 'Admin']);
        User::where('role', 'editor')->update(['role' => 'Editor']);
        User::where('role', 'client')->update(['role' => 'Client']);
        User::where('role', 'author')->update(['role' => 'Manager']);
        User::where('role', 'maintainer')->update(['role' => 'Manager']);
    }
}
