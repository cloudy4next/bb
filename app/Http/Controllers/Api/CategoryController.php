<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategory(Request $request)
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();

            return response()->json(['success' => $categories], 200);

    }


    public function storeCategory(Request $request)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|min:3|max:255|string',
                'parent_id' => 'sometimes|nullable|numeric'
                ]);

        Category::create($validatedData);

        return response()->json([ 'success' =>  'You have successfully created a Category!'],200);
    }


    public function updateCategory(Request $request, Category $category)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|min:3|max:255|string'
                ]);

        $category->update($validatedData);

        return response()->json([ 'success' => 'You have successfully updated a Category!'],200);
    }


    public function deleteCategory(Request $request)
        {
            $category = Category::findOrFail($request->id);

            if ($category->children) {
            foreach ($category->children()->with('pages')->get() as $child) {
                foreach ($child->pages as $page) {
                    $page->update(['category_id' => NULL]);
                    }
                    }

                    $category->children()->delete();
                }

            foreach ($category->pages as $page) {
                    $page->update(['category_id' => NULL]);
                    }

            $category->delete();

            return response()->json([ 'success' => 'You have successfully Delete a Category!'],200);
        }

}