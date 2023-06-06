<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class SubCategoryController extends Controller
{
    public function AllSubCategory()
    {

        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.subcategory_all', compact('subcategories'));
    } //End Method

    public function AddSubCategory()
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        return view('backend.subcategory.subcategory_add', compact('categories'));
    } //End Method

    public function StoreSubCategory(Request $request)
    {

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
            'created_at' => Carbon::now()

        ]);

        $notification = [
            'message' => 'SubCategory Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.subcategory')->with($notification);
    } //end Method
}
