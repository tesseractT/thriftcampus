<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as Image;


class CategoryController extends Controller
{

    public function AllCategory()
    {
        $categories = Category::latest()->get();
        return view('backend.category.category_all', compact('categories'));
    } //End Method
    public function AddCategory()
    {
        $categories = Category::latest()->get();
        return view('backend.category.category_add', compact('categories'));
    }
    //end Method

    public function StoreCategory(Request $request)
    {
        $image = $request->file('category_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(300, 300)->save('upload/category/' . $name_gen);

        $save_url = 'upload/category/' . $name_gen;

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
            'category_image' => $save_url,
            'created_at' => Carbon::now()

        ]);

        $notification = [
            'message' => 'Category Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.category')->with($notification);
    } //end Method


    public function EditCategory($id)
    {
        $categories = Category::findOrFail($id);
        return view('backend.category.category_edit', compact('categories'));
    } //end Method

    public function UpdateCategory(Request $request)
    {
        $category_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('category_image')) {
            $image = $request->file('category_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/category/' . $name_gen);

            $save_url = 'upload/category/' . $name_gen;

            if (file_exists($old_img)) {
                unlink($old_img);
            }

            Category::findOrFail($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                'category_image' => $save_url,
                'updated_at' => Carbon::now()

            ]);

            $notification = [
                'message' => 'Category Updated With Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.category')->with($notification);
        } else {
            Category::findOrFail($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                'updated_at' => Carbon::now()

            ]);

            $notification = [
                'message' => 'Category Updated Without Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.category')->with($notification);
        }
    } //End Method

    public function DeleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $img =  $category->category_image;
        unlink($img);

        Category::findOrFail($id)->delete();

        $notification = [
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } //End Method


}
