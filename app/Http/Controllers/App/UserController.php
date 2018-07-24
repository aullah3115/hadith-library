<?php

namespace App\Http\Controllers\App;

use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request){
      $user = $request->user();
      $roles = $user->getRoleNames();
      return response()->json(['user' => $user, 'roles' => $roles, 'status' => 200]);
    }

    public function getAll(){
      $users = User::all();

      return response()->json(['users' => $users, 'status' => 200]);
    }

    public function getUserRoles($id){
      $user = User::find($id);
      $roles = $user->roles;

      return response()->json(['roles' => $roles, 'status' => 200]);
    }

    public function getRolePermissions($id){
      $role = Role::find($id);
      $permissions = $role->permissions;

      return response()->json(['permissions' => $permissions, 'status' => 200]);
    }

    public function getRoles(){
      $roles = Role::all();

      return response()->json(['roles' => $roles, 'status' => 200]);
    }

    public function getPermissions(){
      $permissions = Permission::all();

      return response()->json(['permissions' => $permissions, 'status' => 200]);
    }

    public function createPermission(Request $request){
      $data = $request->all();
      $permission = Permission::create(['name' => $data['name']]);

      foreach ($data['roles'] as $key => $role) {
        $permission->assignRole($role);
      }

      return response()->json(['permission' => $permission, 'status' => 200]);
    }

    public function createRole(Request $request){
      $data = $request->all();
      $role = Role::create(['name' => $data['name']]);

      foreach ($data['permissions'] as $key => $permission) {
        $role->givePermissionTo($permission);
      }
      
      return response()->json(['role' => $role, 'status' => 200]);
    }
}
