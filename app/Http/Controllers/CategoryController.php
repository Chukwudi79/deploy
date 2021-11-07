<?php

namespace App\Http\Controllers;

use App\Models\Selectoption\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

       return response()->json(['data' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create($request->all());

        return response()->json(['status' => 'success', 'message' => 'Category Successfully Created']);
    }

    public function show(Category $category)
    {
        return response()->json(['data' => $category]);
    }


    public function update(Category $category, Request $request )
    {
        $request->validate(['name'=>'required']);

        $category->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Category Successfully Updated']);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['status' => 'success', 'message' => 'Category Successfully Deleted']);
    }
}
