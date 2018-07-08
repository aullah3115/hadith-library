<?php

namespace App\Http\Controllers\App;

//use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request){
      $user = $request->user();
      return response()->json(['user' => $user, 'status' => 200]);
    }
}
