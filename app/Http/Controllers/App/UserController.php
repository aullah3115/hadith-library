<?php

namespace App\Http\Controllers\App;

use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WebNotification;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

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

    public function subscribeToPush(Request $request){
      $user = $request->user();
      $endpoint = $request->input('endpoint');
      $key = $request->input('keys')['p256dh'];
      $token = $request->input('keys')['auth'];
      $user->updatePushSubscription($endpoint, $key , $token);

      //$response = $user->notify(new WebNotification('Welcome', 'Body'));
      //return response()->json($response);
      //return $request;
    }

    public function sendPush(Request $request){
      $user = $request->user();
      $message = $request->input('message');
      
      $subscriptions = $user->pushSubscriptions;

      $public_key = config('webpush.vapid.public_key');
      $private_key = config('webpush.vapid.private_key');

      $auth = [
        //'GCM' => 'MY_GCM_API_KEY', // deprecated and optional, it's here only for compatibility reasons
        'VAPID' => [
            'subject' => 'mailto:aullah3115@yahoo.co.uk', // can be a mailto: or your website address
            'publicKey' => $public_key,
            'privateKey' => $private_key,
            //'pem' => 'pemFileContent', // if you have a PEM file and want to hardcode its content
        ],
    ];

    $webPush = new WebPush($auth);

      foreach ($subscriptions as $key => $value) {

        $subscription = Subscription::create([
          'endpoint' => $value->endpoint, 
          'publicKey' => $value->public_key, 
          'authToken' => $value->auth_token,
         ]);

          $response = $webPush->sendNotification(
            $subscription,
            $message,
            true
          );

          if(is_array($response)){
            if($response['expired']){
              $user->pushSubscriptions()
              ->where('endpoint', $value->endpoint)
              ->delete();
            }
          }
      }
      //$response = $webPush->flush();
      //return response()->json(['response' => $response]);
      //return $user->notify(new WebNotification('Welcome', 'Body'));
    }

}
