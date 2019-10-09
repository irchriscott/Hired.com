<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Subcategory;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function categories(){
        return view('admin.categories')->with('categories', Category::all());
    }

    public function storeCategory(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:4999'
        ]);
        
        //Handle File
        
        $filenameWithExt = $request->file('image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $fileToStore = 'category_'.$filename.'_'.time().'.'.$extension;
        $path = $request->file('image')->storeAs('public/category_images', $fileToStore); 
        

        //Save Category

        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->image = $fileToStore;
        $category->save();

        session()->flash('success', 'Category Added Successfully !!!');

        return redirect(route('admin.categories'));
    }

    public function subcategories(){
        return view('admin.subcategory');
    }

    public function storeSubcategory(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'icon_name' => 'nullable'
        ]);

        $isTeachable = ($request->input('is_teachable') == 'true') ? true : false;
        
        $subcategory = new Subcategory();
        $subcategory->name = $request->input('name');
        $subcategory->description = $request->input('description');
        $subcategory->icon_type = $request->input('icon_type');
        $subcategory->icon_name = $request->input('icon_name');
        $subcategory->is_teachable = $isTeachable;
        $subcategory->category_id = $request->input('category_id');
        $subcategory->save();

        session()->flash('success', 'Subcategory Added Successfully !!!');

        return redirect(route('admin.categories'));
    }
}
