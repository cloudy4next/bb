<?php

namespace App\Http\Controllers\Api\Auth;


use Illuminate\Http\Request;
use Response;
use App\Models\User;
use Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{


     public function __construct()
     {
        $this->middleware('guest');
     }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
         ['name' => 'required|string|max:255',
         'mobile_number' => 'required|string|max:255',
         'email' => 'required|string|email|unique:users|max:255',
         'password' => 'required|string|min:6|confirmed',]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        User::create([
        'name' => $request->name,
        'name' => $request->mobile_number,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        ]);

        $response = ["message" =>'User Registered Sucessfully'];
        return response($response, 200);
    }

}