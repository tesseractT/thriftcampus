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

    public function EditSubCategory($id)
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('backend.subcategory.subcategory_edit', compact('categories', 'subcategory'));
    } //End Method

    public function UpdateSubCategory(Request $request)
    {
        $subcat_id = $request->id;

        SubCategory::findOrFail($subcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
            'updated_at' => Carbon::now()

        ]);

        $notification = [
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.subcategory')->with($notification);
    } //End Method

    public function DeleteSubCategory($id)
    {
        SubCategory::findOrFail($id)->delete();

        $notification = [
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.subcategory')->with($notification);
    } //End Method
}
