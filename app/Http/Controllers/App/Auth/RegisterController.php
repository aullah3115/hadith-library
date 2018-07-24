<?php

namespace App\Http\Controllers\App\Auth;

use App\User;
use App\NeoEloquent\Entities\User as NeoUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterNewUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{


    public function register(RegisterNewUser $request)
    {

        $validated = $request->validated();

        $name = $validated['name'];
        $email = $validated['email'];
        $username = $validated['username'];
        $password = bcrypt($validated['password']);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $neo_user = NeoUser::create([
          'name' => $name,
          'email' => $email,
          'password' => $password,
          'sql_id' => $user->id,
        ]);

        $user->assignRole('user');

        //Auth::logout();

        $data = [
          'email' => $validated['email'],
          'password' => $validated['password']
        ];

        $request = Request::create('/vue/login', 'POST', $data);

        $response = app()->handle($request);

        return $response;

        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => 'There was an error signing you in',
                'status' => 422
            ], 422);
        }

        return json_decode($response->getContent());
        /*
        return response()->json([
          'user' => $user,
          'status' => 201
        ]);
        */
    }

}
