<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Str;

class userController extends Controller
{
    //1
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:32',
            'role_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }
        $user = new User;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->name = $request->name;
        $user->role_id = $request->role_id;
        $user->api_token = hash_hmac('sha256', Str::random(64), config('app.key'));
        $user->save();
        return response()->json(['description' => 'Created'], 200);
    }
    //2
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:32',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }
        
        $user = User::where(['email' => $request->email, 'password' => $request->password])->select('email','api_token')->first();
        if(!$user){
            return response()->json(['description' => 'login failed'], 403);
        }
        return response()->json(['description' => 'logined', 'data' => $user ],200);
    }
}
