<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ResetPasswordController extends Controller
{
    public function postChangePasswordForm(ChangePasswordRequest $request)
    {
        // $user = Auth::user();
        $user = $this->guard()->user();
        $user->password = Hash::make($request->new_password);

        if ($user->save()) {
            $response = ["message" => trans('base.account_updated')];
            return response($response, 200);
        } else {
            $response = ["message" => trans('base.error_saving')];
            return response($response, 422);
        }
    }

    /**
    * Get the guard to be used for account manipulation.
    *
    * @return \Illuminate\Contracts\Auth\StatefulGuard
    */
    protected function guard()
    {
        return auth();
    }
}