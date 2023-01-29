<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class PermissionController extends Controller
{

    public function createRole(Request $request)
    {

        $validator = Validator::make($request->all(),
                        ['name'=> 'required|string|unique:roles|max:20',]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        // Create role and assign permission to it.
        Role::create(["name" => $request->name])->givePermissionTo(Permission::all()); //need array to fill permission

        return response()->json(['success' => 'Role Created Successfully'], 200);


    }

    public function revokeRole($userId,$roleId)
    {
        User::find($userId)->removeRole($roleId); //remove role name //
    }

}