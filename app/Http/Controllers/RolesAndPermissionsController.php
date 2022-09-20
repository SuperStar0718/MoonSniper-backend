<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsController extends Controller
{
    public function getRolesAndPermissions()
    {
        $roles = Role::all()->pluck('name');
        $ArrayPermission = [];
        foreach ($roles as $key => $value) {

            if ($value != 'Admin') {
                $role = Role::findByName( $value, 'web');
                $ArrayPermission[$value] = $role->permissions->whereNotIn('name', ['Dashboard', 'Profile', 'Unautherize','All'])->pluck('name');
            }
        }
        $permissions = Permission::whereNotIn('name', ['Dashboard', 'Profile', 'Unautherize'])->pluck('name');
        return response()->json(['rolepermissions' => $ArrayPermission, 'permissions' => $permissions]);
    }
    public function updateRolePermissions(Request $request)
    {
        $permissions = json_decode($request->permissions);
        foreach ($permissions as $key => $value) {
            $pms = [];
            if ($key != 'Admin' ) {
                $role = Role::findByName($key, 'web');
                $ArrayPermissions = $role->permissions->pluck('name');
                foreach ($ArrayPermissions as $key2 => $value2) {
                    $role->revokePermissionTo($value2);
                }
                $role->getPermissionNames();
                if (in_array("All", $value)) {
                    $permissions2 = Permission::where('name','!=','All')->pluck('name');
                     $role->givePermissionTo($permissions2);
                }else{
                    $pms = $value;
                    array_push($pms, 'Dashboard', 'Profile', 'Unautherize');
                    $role->givePermissionTo($pms);
                }
               
            }
        }
        return response()->json(['status' => true]);
    }
    public function loadAbilities()
    {
        $user = Auth::user();
        $ability = [];
        if ($user->role == 'Admin') {
            $ability[0] = ["action" => "manage", "subject" => "all"];

        } else {
            $permissions = $user->roles[0]->permissions->pluck('permission_string');

            foreach ($permissions as $key => $value) {
                if ($value) {
                    $value = json_decode($value);
                    $ability[$key] = $value;

                }
            }
        }
        return $ability;
    }

}
