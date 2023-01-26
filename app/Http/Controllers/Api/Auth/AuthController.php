<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;


class AuthController extends Controller
{

    public function login (Request $request)
    {

    $validator = Validator::make($request->all(), ['email' => 'required|string|email|max:255',
    'password' => 'required|string|min:6',]);

    if ($validator->fails())
    {
        return response(['errors'=>$validator->errors()->all()], 422);
    }

    $user = User::where('email', $request->email)->first();

    if ($user) {
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['token' => $token];
            return response($response, 200);
        } else {
            $response = ["message" => "Password mismatch"];
            return response($response, 422);
        }
        }   else {
            $response = ["message" =>'User or email id does not exist'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

}