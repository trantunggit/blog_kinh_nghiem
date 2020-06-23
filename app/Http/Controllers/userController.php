<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Str;

define('RESPONSE_STATUS_FORBIDDEN', 403);
define('RESPONSE_STATUS_OK', 200);

class userController extends Controller
{
    //1
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:32',
            'level' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), RESPONSE_STATUS_FORBIDDEN);
        }
        $user = new User;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->level = $request->level;
        $user->api_token = hash_hmac('sha256', Str::random(64), config('app.key'));
        $user->save();
        return response()->json(['description' => 'Created'], RESPONSE_STATUS_OK);
    }
    //2
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:32',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), RESPONSE_STATUS_FORBIDDEN);
        }
        
        $user = User::where(['email' => $request->email, 'password' => $request->password])->select('email','api_token')->first();
        if(!$user){
            return response()->json(['description' => 'login failed'], RESPONSE_STATUS_FORBIDDEN);
        }
        return response()->json(['description' => 'logined', 'data' => $user ],RESPONSE_STATUS_OK);
    }
}
