<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view("categories.index", compact("categories"));
    }

    public function showCreateCategory()
    {
        return view("categories.create");
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|string|unique:categories',
        ]);
        try {
            $status = $request->has('status') ? 'active' : 'inactive';
            Category::create([
                'name' => $request->name,
                'status' => $status
            ]);
            return redirect('/category')->with('success', 'Category Created successfully');
        } catch (\Exception $e) {
            return redirect('category')->with('error', 'Unable to Create category');
        }
    }

    public function showEditCategory($id)
    {
        $category = Category::findOrFail($id);
        return view("categories.edit", compact('category'));
    }
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100|string',
        ]);
       
        try{
             $category = Category::findOrFail($id);
            $status = $request->has('status') ? 'active' : 'inactive';
        $category->update([
            'name' => $request->name,
            'status' => $status
        ]);
        return redirect('/category')->with('success', 'category Upadted Successfully');
        }catch(\Exception $e){
            return redirect('/category')->with('error', 'Unable to Update category');
        }
    }
    public function destroy($id)
    {
        
        try{
           $category = Category::findOrFail($id);
        if ($category->products()->exists()) {
            return redirect('/category')->with('error', "Can't delete cause it's have product");
        }
        $category->delete();
        return redirect('/category')->with('success', 'Deleted Successfully');
        }catch(\Exception $e){
            return redirect('/category')->with('error','Unable to delete Category');
        }
    }
}
