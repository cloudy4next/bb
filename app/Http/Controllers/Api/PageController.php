<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Category;
use App\Models\User;
use Auth;

class PageController extends Controller
{


    public function getPages(Request $request)
    {
        if(Auth::check()) {

            $data = Page::with('category')->where('user_id' , Auth::id())->get();
            return response()->json(['success' => $data], 200);

        }
    }

   public function pageStore(Request $request)
    {
        $validatedData = $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'image' => 'sometimes|image',
            'category_id' => 'required|numeric',
            'description' => 'required|min:3'
            ]);

        $validatedData['user_id'] = Auth::id();

        $post = Page::create($validatedData);

        return response()->json([ 'success' => 'You have successfully Created a Page!'],200);

    }



}