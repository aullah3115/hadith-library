<?php

namespace App\Http\Controllers\App\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{

    public function login(Request $request)
    {

      $credentials = $request->only('email', 'password');

      if (!Auth::attempt($credentials)) {

          return response()->json([
              'message' => 'Wrong email or password 1',
              'status' => 422
          ], 422);

        }


      $user = Auth::user();

      Auth::logout();

      // Send an internal API request to get an access token
      $data = [
          'grant_type' => 'password',
          'client_id' => config('passport.client_id'),
          'client_secret' => config('passport.client_secret'),
          'username' => request('email'),
          'password' => request('password'),
      ];

      $request = Request::create('/oauth/token', 'POST', $data);

      $response = app()->handle($request);

      // Check if the request was successful
      if ($response->getStatusCode() != 200) {
          return response()->json([
              'message' => 'Wrong email or password 3',
              'status' => 422
          ], 422);
      }

      // Get the data from the response
      $data = json_decode($response->getContent());

      $token = $data->access_token;
    
      // Format the final response in a desirable format
      return response()
            ->json([
                    //'token' => $data->access_token,
                    'user' => $user,
                    'status' => 200
                    ])
            ->cookie('token', $token, 3600//, '/'//,, true, true
          );
    }

    public function logout(Request $request)
    {
        $accessToken = $request->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        //Auth::logout();
        Cookie::queue(Cookie::forget('token'));
        return response()->json(['status' => 200]);

    }
}
