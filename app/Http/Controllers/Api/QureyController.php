<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Query;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class QureyController extends Controller
{
   public function storeQuries(Request $request)
   {
        $validator = Validator::make($request->all(),
                ['name'=> 'required|string|max:255',
                'email'=> 'required|string|email|max:255',
                'phone'=> 'required|string|max:15',
                'title'=> 'required|string|max:255',
                'description'=> 'required|min:3|max:1000',
            ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $queryStore = new Query();
        $queryStore->name = $request->name;
        $queryStore->email = $request->email;
        $queryStore->phone = $request->phone;
        $queryStore->title = $request->title;
        $queryStore->description = $request->description;
        $queryStore->created_at = Carbon::now();
        $queryStore->save();

       return response()->json(['success' => 'Data Saved Successfully'], 200);

    }

    public function responseQurey(Request $request)
    {
        $queryResponseStore = Query::find($request->id);
        $queryResponseStore->status = $request->status; // set 1 on response sent //
        $queryResponseStore->response_text = $request->response_text;
        $queryResponseStore->updated_at = Carbon::now();
        $queryResponseStore->save();

        // TO DO Email Template

        return response()->json(['success' => 'Response Sent Successfully'], 200);

    }


    public function getQuries(Request $request)
    {
        $data = Query::latest()->take(10)->where('status', '0')->get();
        return response()->json(['success' => $data], 200);
    }


}